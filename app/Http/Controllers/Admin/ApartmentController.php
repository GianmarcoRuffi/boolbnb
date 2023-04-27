<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Monarobase\CountryList\CountryListFacade;
use Illuminate\Support\Facades\Storage;
use App\Apartment;
use App\Image;
use App\Service;
use App\User;
use App\Sponsorship;
use Illuminate\Support\Facades\Auth;

class ApartmentController extends Controller
{   
    protected $myTomTomApiKey = 'YeAUs1VSBC9gVGieDMDGZZVGtnxy9myl';
    protected $validationRulesStore = [
        "title" => "required|string|max:150",
        "description" => "string|max:16777215|nullable",
        "rooms" => "required|integer|min:0|max:255",
        "beds" => "required|integer|min:0|max:255",
        "bathrooms" => "required|integer|min:0|max:255",
        "square_meters" => "integer|min:0|max:65535|nullable",
        "visible" => "sometimes|accepted",
        "price" => "required|numeric",
        "nation" => "required|string|max:60",
        "address" => "required|string|max:255",
        "image" => "required",
        "image.*" => "image|max:1024"
    ];
    protected $validationRulesUpdate = [
        "title" => "required|string|max:150",
        "description" => "string|max:16777215|nullable",
        "rooms" => "required|integer|min:0|max:255",
        "beds" => "required|integer|min:0|max:255",
        "bathrooms" => "required|integer|min:0|max:255",
        "square_meters" => "integer|min:0|max:65535|nullable",
        "visible" => "sometimes|accepted",
        "price" => "required|numeric",
        "nation" => "required|string|max:60",
        "address" => "required|string|max:255",
        "image.*" => "sometimes|image|max:1024"
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Auth::user()->id);
        $apartments = Apartment::all()->where("user_id", Auth::user()->id);
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = Service::all();
        $countries = CountryListFacade::getList('it');
        return view('admin.apartments.create', compact('services', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        $request->validate($this->validationRulesStore);
        $data = $request->all();
        $response = Http::get('https://api.tomtom.com/search/2/structuredGeocode.json', [
            'key' => $this->myTomTomApiKey,
            'countryCode' => $data['nation'],
            'streetName' => $data['address']
        ]);
        $decoded = json_decode($response->body());
        if($decoded->results == []){
            return redirect()->route('admin.apartments.create')->with('message', 'Non riusciamo a trovare l\'indirizzo inserito, riprova.');
        } else {
            $newApartment = new Apartment();
            $newApartment->title = $data['title'];
            $newApartment->description = $data['description'];
            $newApartment->rooms = $data['rooms'];
            $newApartment->beds = $data['beds'];
            $newApartment->bathrooms = $data['bathrooms'];
            $newApartment->square_meters = $data['square_meters'];
            $newApartment->visible = isset($data['visible']);
            $newApartment->price = $data['price'];
            $newApartment->sponsored = false;
            $newApartment->nation = $data['nation'];
            $newApartment->address = $data['address'];
            $newApartment->longitude = $decoded->results[0]->position->lon;
            $newApartment->latitude = $decoded->results[0]->position->lat;
            $newApartment->slug = $this->getSlug($newApartment->title);
            $newApartment->user_id = Auth::user()->id;

            $newApartment->save();

            if(isset($data['image'])){
                foreach($data['image'] as $img){
                    $newImage = new Image();
                    $path_image = Storage::put("uploads", $img);
                    $newImage->image = $path_image;
                    $newImage->apartment_id = $newApartment->id;
                    $newImage->save();
                }
            }
            
            if(isset($data['services'])){
                $newApartment->services()->sync($data['services']);
            }

            return redirect()->route('admin.apartments.show', $newApartment->id);
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
        $apartment = Apartment::findOrFail($id);
        $country = CountryListFacade::getOne($apartment->nation,'it');
        return view('admin.apartments.show', compact('apartment', 'country'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {   
        $services = Service::all();
        $countries = CountryListFacade::getList('it');
        $country = CountryListFacade::getOne($apartment->nation,'it');
        return view('admin.apartments.edit', compact('apartment', 'services', 'countries', 'country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Apartment $apartment)
    {
        $request->validate($this->validationRulesUpdate);
        $data = $request->all();
        $response = Http::get('https://api.tomtom.com/search/2/structuredGeocode.json', [
            'key' => $this->myTomTomApiKey,
            'countryCode' => $data['nation'],
            'streetName' => $data['address']
        ]);
        $decoded = json_decode($response->body());
        if($decoded->results == []){
            return redirect()->route('admin.apartments.create')->with('message', 'Non riusciamo a trovare l\'indirizzo inserito, riprova.');
        } else {

            if($apartment->title != $data['title']){
                $apartment->title = $data['title'];
                if(Str::of($apartment->title)->slug('-') != $apartment->slug){
                    $apartment->slug = $this->getSlug($apartment->title);
                }
            }
            $apartment->description = $data['description'];
            $apartment->rooms = $data['rooms'];
            $apartment->beds = $data['beds'];
            $apartment->bathrooms = $data['bathrooms'];
            $apartment->square_meters = $data['square_meters'];
            $apartment->visible = isset($data['visible']);
            $apartment->price = $data['price'];
            $apartment->sponsored = $apartment->sponsored;
            $apartment->nation = $data['nation'];
            $apartment->address = $data['address'];
            $apartment->longitude = $decoded->results[0]->position->lon;
            $apartment->latitude = $decoded->results[0]->position->lat;

            $apartment->update();

            if(isset($data['image'])){
                foreach($data['image'] as $img){
                    $newImage = new Image();
                    $path_image = Storage::put("uploads", $img);
                    $newImage->image = $path_image;
                    $newImage->apartment_id = $apartment->id;
                    $newImage->save();
                }
            }

            if(isset($data['services'])){
                $apartment->services()->sync($data['services']);
            } else {
                $apartment->services()->sync([]);
            }

            return redirect()->route('admin.apartments.show', $apartment->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        foreach($apartment->images as $img){
            Storage::delete($img->image);
        }
        $apartment->services()->sync([]);
        $apartment->images()->delete();
        $apartment->delete();
        return redirect()->route('admin.apartments.index');
    }

    /**
     * Generate an unique slug
     *
     * @param  string $title
     * @return string
     */
    private function getSlug($title)
    {
        $slug = Str::of($title)->slug("-");
        $count = 1;
        while( Apartment::where("slug", $slug)->first() ) {
            $slug = Str::of($title)->slug("-") . "-{$count}";
            $count++;
        }
        return $slug;
    }
}
