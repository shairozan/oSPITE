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