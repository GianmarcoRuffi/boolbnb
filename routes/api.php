<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/apartments/{userInput}/{userRange}/{userRooms}/{userBeds}/{userServices}', 'Api\ApartmentController@index');
Route::get('/apartments/{slug}','Api\ApartmentController@show');

Route::get('/services','Api\ServiceController@index');
Route::post('/messages', 'Api\MessageController@store');
Route::get('/sponsorships','Api\SponsorshipController@index');