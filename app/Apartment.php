<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function images(){
        return $this->hasMany('App\Image');
    }

    public function messages(){
        return $this->hasMany('App\Message');
    }

    public function views(){
        return $this->hasMany('App\View');
    }

    public function services(){
        return $this->belongsToMany('App\Service');
    }

    public function sponsorships(){
        return $this->belongsToMany('App\Sponsorship')->withPivot('apartment_id', 'sponsorship_id', 'expiry');
    }
}
