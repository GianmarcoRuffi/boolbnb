<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = config('servizi');
        foreach($services as $service){
            $newService = new Service();
            $newService->name = $service;
            $newService->slug = Str::of($newService->name)->slug('-');
            $newService->save();
        }
    }
}
