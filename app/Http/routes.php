<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::resource('characters','CharactersController');

Route::get('/test',function(){
    //start with weapon 1
//    $weapon = App\Weapon::find(1);
//    $weapon->fillRelations();
//
//    foreach($weapon->relationships as $type => $contents){
//        echo $type;
//        echo '<br />';
//
//        foreach($contents as $c){
//            dd($c);
//        }
//    }

    return view('layouts.master');
});


Route::post('/search','SearchController@store');
Route::get('/search','SearchController@store');

//Route to dynamically pull and serve images out of the app storage location
Route::get('/images/{campaign}/{file}',function($campaign,$file){

    if( \Storage::disk('local')->exists('/uploads/campaign_' . $campaign . '/' . $file)) {
        return \Response::download( storage_path() . '/app/uploads/campaign_' . $campaign . '/' . $file,$file);
    } else {
        return response([
            'message' => 'Record not found',
        ],404);
    }
});



// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');