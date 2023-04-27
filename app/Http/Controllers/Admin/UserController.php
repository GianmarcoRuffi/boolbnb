<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function check(){
        if(Auth::check()){
            return response()->json(Auth::user()->email);
        } else {
            return response()->json('');
        }
    }
}
