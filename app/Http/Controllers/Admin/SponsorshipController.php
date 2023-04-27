<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Apartment;
use App\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;



class SponsorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sponsors = Sponsorship::all();
        $apartments = Apartment::all()->where("user_id", Auth::user()->id);
        return view('admin.sponsorships.index', compact('sponsors','apartments'));
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
     * Stores a sponsorship on db
     *
     * @param number $sponsorship_id
     * @param number $duration
     * @param number $apartment_id
     * 
     * @return Response $response
     * 
     */
    public function store($sponsorship_id, $duration, $apartment_id)
    {   
        // salvo la data di oggi
        $today = date_create(date("Y-m-d"));
        // // salvo l'appartamento interessato dalla sponsorizzazione
        $apartment = Apartment::findOrFail($apartment_id);

        // // salvo tutte le sponsorizzazioni dell'appartamento interesasto
        $sponsorships = Sponsorship::join('apartment_sponsorship', 'apartment_sponsorship.sponsorship_id', '=', 'sponsorships.id')
        ->where('apartment_id', '=', $apartment_id)->select('apartment_sponsorship.*')->get();

        // controllo che ci siano delle sponsorizzazioni
        if(count($sponsorships) != 0){
            // controllo che la data di fine della sponsorizzazione più recente sia passata
            if(date_create($sponsorships[count($sponsorships) - 1]->expiry) < $today){
                // creo una stringa che indichi le ore totali della sponsorizzazione
                $duration = $duration .' hours';
                // salvo la data di fine della sponsorizzazione aggiungendo a oggi la stringa creata in precendeza
                $expiry = date_add($today, date_interval_create_from_date_string($duration));
                // salvo la sponsorizzazione
                $apartment->sponsorships()->attach($sponsorship_id, ['expiry' => $expiry]);
            

                // reindirizzo alla stessa pagina con un messaggio di successo
                return redirect()->route('admin.sponsorships.index')->with("success_message","Hai sponsorizzato l'appartamento \"{$apartment->title}\" fino al {$expiry->format('d-m-Y')}");
            } else { // se la data di fine della sponsorizzazione non è ancora passata, reindirizzo alla stessa pagina con un messaggio di errore
                $until = date_create($sponsorships[count($sponsorships) - 1]->expiry)->format('Y-m-d');
                return redirect()->route('admin.sponsorships.index')->with("error_message","L'appartamento \"{$apartment->title}\" è già sponsorizzato fino al {$until}");
            }
        } else { // se non ci sono sponsorizzazioni, salto il controllo della data e salvo direttamente la sponsorizzazione
            $duration = $duration . ' hours';
            $expiry = date_add($today, date_interval_create_from_date_string($duration));
            $apartment->sponsorships()->attach($sponsorship_id, ['expiry' => $expiry]);
            return redirect()->route('admin.sponsorships.index')->with("success_message","Hai sponsorizzato l'appartamento \"{$apartment->title}\" fino al {$expiry->format('d-m-Y')}");
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
