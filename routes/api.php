<?php

use Illuminate\Http\Request;

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
Route::get('v1/{code}/main', 'Api\v1\MainController@index')->name('api.main');
Route::get('v1/{code}/agent-detail', 'Api\v1\MainController@detail')->name('api.agent-detail');

Route::get('v1/{code}/umrah-flights', 'Api\v1\FlightsController@index')->name('api.umrah-flights');
Route::get('v1/{code}/umrah-flights-airlines', 'Api\v1\FlightsController@airlines')->name('api.umrah-flights-airlines');
Route::get('v1/{code}/umrah-flights-from-cities', 'Api\v1\FlightsController@fromCities')->name('api.umrah-flights-from-cities');
Route::get('v1/{code}/umrah-flights-to-cities', 'Api\v1\FlightsController@toCities')->name('api.umrah-flights-to-cities');

Route::get('v1/{code}/sasti-tickets', 'Api\v1\SastiTicketsController@index')->name('api.sasti-tickets');
Route::get('v1/{code}/sasti-tickets-airlines', 'Api\v1\SastiTicketsController@airlines')->name('api.sasti-tickets-airlines');
Route::get('v1/{code}/sasti-tickets-to-cities', 'Api\v1\SastiTicketsController@toCities')->name('api.sasti-tickets-to-cities');
Route::get('v1/{code}/sasti-tickets-from-cities', 'Api\v1\SastiTicketsController@fromCities')->name('api.sasti-tickets-from-cities');

Route::get('v1/{code}/umrah-hotels', 'Api\v1\HotelsController@index')->name('api.umrah-hotels');
Route::get('v1/{code}/hotels-cities', 'Api\v1\HotelsController@cities')->name('api.hotels-cities');
Route::get('v1/{code}/hotels-types', 'Api\v1\HotelsController@types')->name('api.hotels-types');
Route::get('v1/{code}/hotels-list', 'Api\v1\HotelsController@list')->name('api.hotels-list');

Route::get('v1/{code}/umrah-package', 'Api\v1\PackageController@index')->name('api.umrah-package');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
