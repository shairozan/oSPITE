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
    Route::get('/campaigns/create','CampaignsController@create');
});


//Requires auth as well as a defined campaign object
Route::group(['middleware' => ['auth','campaign']], function () {
    Route::get('/', 'DashboardsController@index');

    /* Magic Deletion Routes. Exist before the Resource Controllers
    So that we don't return them as action function references */
    Route::get('/characters/{id}/delete','CharactersController@destroy');
    Route::get('/weapons/{id}/delete','WeaponsController@destroy');

    /* --------------------------------------------------------*/
    Route::resource('characters','CharactersController');
    Route::resource('adventures','QuestLogsController');
    Route::resource('journals','QuestLogsController');
    Route::resource('weapons','WeaponsController');
    Route::resource('relationships','RelationshipsController');
    Route::get('/adventures/{id}/delete','QuestLogsController@destroy');

    Route::get('/relationships/create/{source_type}/{source_id}','RelationshipsController@map');


    //API Objects for datatables queries
    Route::get('/api/characters','CharactersController@dataTable');
    Route::get('/api/weapons','WeaponsController@dataTable');

    //API Object for relationship mapping
    Route::get('/existing/{class}/',function($class){

        if(class_exists($class)) {

            //We have to do campaigns a little differently based on memberships
            if($class == 'App\\Campaign'){
                $memberships = App\CampaignMembership::where('user_id',\Auth::user()->id)->get();
                foreach($memberships as $membership){
                    $summary[] = $membership->details;
                }

            return $summary;
            }

            //Let's pull via the relatable function
            return App\Relatable::listAllCampaignObjectsOfType(new $class())->get();
        } else {
            return \Response::json(['error'=>'The class you are trying to access is invalid'],502);
        }
    });

    //Raw text for tests
    Route::get('/test/characters','CharactersController@testIndex');
    Route::get('/test/weapons','WeaponsController@testIndex');



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