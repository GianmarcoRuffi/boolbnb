<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    protected $guarded = [];
    
    public function apartments(){
        return $this->belongsToMany('App\Apartment')->withPivot('apartment_id', 'sponsorship_id', 'expiry');
    }
}
