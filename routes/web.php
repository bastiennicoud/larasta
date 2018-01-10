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

Route::get('/', 'InternshipsController@index');

Route::post('/', 'InternshipsController@changeFilter');

Route::get('/internships/{iid}/edit','InternshipsController@edit');

Route::get('/about', function () {
    return view('about');
});

Route::get('/remarks', 'RemarksController@index');

Route::post('/remarks/filter','RemarksController@filter');

Route::post('/remarks/add','RemarksController@create');

Route::get('/remarks/{rid}/edit','RemarksController@edit');

Route::post('/remarks/delete','RemarksController@delete');

Route::post('/remarks/update','RemarksController@update');

// Antonio - Entreprises list
Route::get('/entreprises', 'EntreprisesController@getCompanies');

// Quentin N - Contract generation
Route::get('/contract', 'ContractController@index');

// Steven

Route::get('/synchro', 'SynchroController@index');
Route::get('/synchro/new', 'SynchroController@new');
Route::get('/synchro/delete', 'SynchroController@delete');

// Jean-Yves
Route::get('/visits','VisitsController@index');

Route::get('/visits/manage','VisitsController@manage');

// Add by Benjamin Delacombaz 12.12.2017 10:40
Route::get('/wishesMatrix', 'WishesMatrixController@index');

// Kevin
Route::get('/traveltime', 'TravelTimeController@index');
Route::post('/traveltime/calculate', 'TravelTimeController@calculate');

// Bastien - Grille d'évaluation
Route::get('/evalgrid', 'EvalController@index');

// Nicolas - Stages
Route::get('/reconstages', 'ReconStagesController@index');

// Davide
Route::get('/listPeople', 'PeopleControlleur@index');
//

//Julien - Grille d'évaluation - Modélisation
Route::get('/editGrid', 'EditGridController@index');

