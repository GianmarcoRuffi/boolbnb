<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware('auth')
    ->namespace('Admin')
    ->name('admin.')
    ->prefix('admin')
    ->group(function(){
        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('/apartments', 'ApartmentController');
        Route::resource('/sponsorships','SponsorshipController');
        Route::post('/sponsorships/{apartment_id}', 'SponsorshipController@store')->name('sponsorships.store');
        Route::resource('/images', 'ImageController');
        Route::get('/users', 'UserController@check');
        Route::any('/payment', 'BraintreeController@token')->name('token');

    });
Route::get("{any?}", function(){
    return view("guest.home");
})->where("any",".*");

