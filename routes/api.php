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
/**
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();

});
 */

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});

Route::group([

    'middleware' => 'jwt.auth'

], function(){

    Route::apiResource('user', 'UserController');
    Route::apiResource('advertisement', 'AdvertisementController', ['except' => ['index', 'show']]);

    Route::put('user/{userId}/personaldata', 'PersonalDataController@update');
    Route::patch('user/{userId}/personaldata', 'PersonalDataController@update');

    Route::delete('user/{userId}/personaldata', 'PersonalDataController@destroy');
    Route::post('user/{userId}/personaldata', 'PersonalDataController@store');

    Route::put('advertisement/{advertisementId}/property', 'PropertyController@update');
    Route::patch('advertisement/{advertisementId}/property', 'PropertyController@update');

    Route::delete('advertisement/{advertisementId}/property', 'PropertyController@destroy');
    Route::post('advertisement/{advertisementId}/property', 'PropertyController@store');
});

Route::get('user/{userId}/personaldata', 'PersonalDataController@index');
Route::get('advertisement/{advertisementId}/property', 'PropertyController@index');
Route::apiResource('advertisement', 'AdvertisementController', ['only' => ['index', 'show']]);