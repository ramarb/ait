<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('user/{id}', 'UserController@show');

Route::post('attribute/map','AttributeController@map');
Route::post('ait/photos','AitController@getPhotos');


Route::resource('partner','PartnerController');
Route::resource('entity','EntityController');
Route::resource('attribute','AttributeController');
Route::resource('photo_up_standard','PhotoUpStandardFieldController');
Route::resource('endpoint','EndpointController');
Route::resource('ait','AitController');