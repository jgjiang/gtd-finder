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
    $areas = null;
    return view('index')->with("areas",$areas);
});

Route::any('/search', "SearchController@show");
Route::any('/showMap', "SearchController@displayMap");