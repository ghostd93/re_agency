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
Route::apiResources([
    'user' => 'UserController',
    'property' => 'PropertyController',
    'advertisement' => 'AdvertisementController'
]);

Route::put('user/{userId}/personaldata', 'PersonalDataController@update');
Route::patch('user/{userId}/personaldata', 'PersonalDataController@update');
Route::get('user/{userId}/personaldata', 'PersonalDataController@index');
Route::delete('user/{userId}/personaldata', 'PersonalDataController@destroy');