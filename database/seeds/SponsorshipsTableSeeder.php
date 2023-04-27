<?php

use Illuminate\Database\Seeder;
use App\Sponsorship;

class SponsorshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sponsorships = config('sponsorizzazioni');
        foreach($sponsorships as $sponsorship){
            $newSponsorship = new Sponsorship();
            $newSponsorship->name = $sponsorship['name'];
            $newSponsorship->duration = $sponsorship['duration'];
            $newSponsorship->price = $sponsorship['price'];
            $newSponsorship->save();
        }
    }
}
