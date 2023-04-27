<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Apartment;

class SponsorshipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // salvo la data di oggi
        $today = date_create(date("Y-m-d"));
        // interrogo il db unendo la tabella appartamenti con la tabella ponte delle sponsorizzazioni, e prendo solo gli appartamenti la cui sponsorizzazione non è ancora scaduta
        // non rischio di prendere più volte lo stesso appartamento perchè l'utente non può comprare una sponsorizzazione se quell'appartamento ne ha ancora una valida
        $sponsorships = Apartment::join('apartment_sponsorship', 'apartment_sponsorship.apartment_id', '=', 'apartments.id')
        ->where('apartment_sponsorship.expiry', '>=', $today)->with("images", "services")->select('apartments.*')->get();
        return response()->json($sponsorships);
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
