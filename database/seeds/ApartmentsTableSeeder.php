<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Apartment;

class ApartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $apartments = config('appartamenti');
        foreach($apartments as $apartment) {
            $newApartment = new Apartment();
            $newApartment->title = $apartment['title'];
            $newApartment->description = $apartment['description'];
            $newApartment->rooms = $apartment['rooms'];
            $newApartment->beds = $apartment['beds'];
            $newApartment->bathrooms = $apartment['bathrooms'];
            $newApartment->square_meters = $apartment['square_meters'];
            $newApartment->visible = $apartment['visible'];
            $newApartment->price = $apartment['price'];
            $newApartment->sponsored = $apartment['sponsored'];
            $newApartment->nation = $apartment['nation'];
            $newApartment->address = $apartment['address'];
            $newApartment->longitude = $apartment['longitude'];
            $newApartment->latitude = $apartment['latitude'];
            $newApartment->slug = Str::slug($newApartment->title);
            $newApartment->user_id = $apartment['user_id'];
            $newApartment->save();
        }
    }
}
