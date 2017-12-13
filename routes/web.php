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


Route::get('/remarks', 'RemarksController@index');

Route::post('/remarks/filter','RemarksController@filter');

Route::post('/remarks/add','RemarksController@create');

Route::get('/remarks/{rid}/edit','RemarksController@edit');

Route::post('/remarks/delete','RemarksController@delete');

Route::post('/remarks/update','RemarksController@update');

Route::get('/contratGen', 'ContratGenController@index');
