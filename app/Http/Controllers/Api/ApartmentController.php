<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Apartment;
use App\Image;

class ApartmentController extends Controller
{
    protected $myTomTomApiKey = 'YeAUs1VSBC9gVGieDMDGZZVGtnxy9myl';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($userInput, $userRange, $userRooms, $userBeds, $userServices)
    {   
        // se l'utente ha scelto dei servizi interrogo il db per ottenere gli appartamenti con quei servizi
        if($userServices != "[]"){
            // trasformo la stringa trasmessa attraverso l'url in un array di id 
            $userServices = explode(',', trim($userServices, "[\]"));
            // interrogo il db
            $apartments = Apartment::select('*')->where('rooms', '>=', $userRooms)->where('beds', '>=', $userBeds)->whereHas('services', function($q) use ($userServices) { 
                $q->whereIn('services.id', $userServices);
            })
            ->withCount(['services' => function($q) use ($userServices) { 
                $q->whereIn('services.id', $userServices); 
            }] )
            ->with(["images", "services"])
            ->having('services_count', '=', count($userServices))->get();
        } else { // se l'utente non ha scelto dei servizi (o nel caso della prima chiamata) interrogo il db per ottenere tutti gli appartamenti
            $apartments = Apartment::select('*')->where('rooms', '>=', $userRooms)->where('beds', '>=', $userBeds)->with(["images", "services"])->get();
        }
        
        // chiamo l'api di tomtom passandole l'indirizzo inserito dall'utente
        $user_response = Http::get('https://api.tomtom.com/search/2/structuredGeocode.json', [
            'key' => $this->myTomTomApiKey,
            'countryCode' => 'it',
            'streetName' => $userInput
        ]);
        $user_decoded = json_decode($user_response->body());
        // salvo le coordinate che l'api mi ha restituito
        $user_lat = $user_decoded->results[0]->position->lat;
        $user_lon = $user_decoded->results[0]->position->lon;

        // preparo due array vuoti, uno in cui successivamente inserirò gli appartamenti nel raggio di ricerca e un altro in cui inseriò un riferimento all'appartamento e la distanza
        $inRangeApts = [];
        $dist_apts = [];

        // per ogni appartamento calcolo la distanza tra le sue coordinate e quelle ottenute da tomtom
        foreach($apartments as $apartment){
            $theta = $user_lon - $apartment->longitude;
            $distance =  (sin(deg2rad($user_lat)) * sin(deg2rad($apartment->latitude))) + (cos(deg2rad($user_lat)) * cos(deg2rad($apartment->latitude)) * cos(deg2rad($theta)));
            $distance = acos($distance);
            $distance = rad2deg($distance);
            $distance = $distance * 60 * 1.1515 * 1.609344;
            $distance = round($distance, 2);
            // in un array inserisco un riferimento all'appartamento e la distanza
            $dist_apt = [
                "distance" => $distance,
                "apt" => $apartment->id
            ];
            // inserisco il piccolo array appena creato nell'array con tutti gli appartamenti e le distanze
            array_push($dist_apts, $dist_apt);
        }
        // ordino l'array in ordine crescente in base alla distanza
        array_multisort($dist_apts, SORT_ASC);
        
        // controllo che l'array non sia vuoto
        if(!empty($dist_apts)){
            $n = count($dist_apts);
            // in tal caso, controllo che ogni elemento presenti una distanza inferiore al raggio di ricerca
            for($i = 0; $i < $n; $i++){
                if($dist_apts[$i]['distance'] > $userRange){
                    // se l'elemento presentauna distanza maggiore del raggio di ricerca, lo elimino dall'array
                    unset($dist_apts[$i]);
                }
            }
        }
        // con la precedente operazione gli indici dell'array potrebbero non essere più continui, quindi uso la funzione array_values per prendere solo i valori dell'array, resettando così gli indici
        $dist_apts = array_values($dist_apts);
        
        // ad ogni elemento dell'array $dist_apts corrisponde un appartamento, quindi ciclo su tale array e per ogni elemento ciclo sulla lista di appartamenti per trovare quello interessato e inserirlo nell'array degli appartamenti da restituire
        for($i = 0; $i < count($dist_apts); $i++){
            foreach($apartments as $apartment){
                if($apartment->id == $dist_apts[$i]['apt']){
                    array_push($inRangeApts, $apartment);
                }
            }
        }

        // salvo la data di oggi
        $today = date_create(date("Y-m-d"));
        // ciclo sull'array degli appartamenti ordinati
        for($i = 0; $i < count($inRangeApts); $i++){
            // salvo il numero di sponsorizzazioni dell'appartamento
            $amount = count($inRangeApts[$i]->sponsorships);
            // se l'appartamento ha più di una sponsorizzazione, confronto la data di scadenza dell'ultima sponsorizzazione con la data di oggi
            if($amount != 0){
                if(date_create($inRangeApts[$i]->sponsorships[$amount - 1]->pivot->expiry) >= $today){ // se la data di scadenza non è ancora passata
                    // salvo in un'altra variabile l'appartamento
                    $move = $inRangeApts[$i];
                    // lo tolgo dall'array
                    unset($inRangeApts[$i]);
                    // lo inserisco nuovamente nell'array in prima posizione
                    array_unshift($inRangeApts, $move);
                }
            }
        }

        // restituisco il risultato
        return response()->json($inRangeApts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $apartment = Apartment::where('slug', $slug)->with('images','services')->first();
        if (empty($apartment)) {
            return response()->json(["message" => "Post not found"], 404);
        }
        return response()->json($apartment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
