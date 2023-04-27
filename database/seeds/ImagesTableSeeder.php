<?php

use Illuminate\Database\Seeder;
use App\Image;

class ImagesTableSeeder extends Seeder
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
            foreach($apartment['images'] as $image) {
                $newImage = new Image();
                $newImage->image = $image;
                $newImage->apartment_id = $apartment['apartment_id'];
                $newImage->save();
            }
        }
    }
}
