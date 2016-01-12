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

//Require authentication to determine what campaigns are available
Route::group(['middleware' => 'auth'], function() {
    Route::get('/campaigns','CampaignsController@index');
    Route::post('/campaigns/select','CampaignsController@campaignSwitch');
});


//Requires auth as well as a defined campaign object
Route::group(['middleware' => ['auth','campaign']], function () {
    Route::get('/', 'DashboardsController@index');
    Route::resource('characters','CharactersController');

    //API Objects for datatables queries
    Route::get('/test/','CharactersController@dataTable');
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