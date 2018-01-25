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

Route::get('/admin', 'AdminController@index');

Route::get('/about', function () {
    return view('about');
});

Route::get('/remarks', 'RemarksController@index');

Route::post('/remarks/filter','RemarksController@filter');

Route::post('/remarks/add','RemarksController@create');

Route::post('/remarks/ajax/add','RemarksController@ajaxCreate');

Route::get('/remarks/{rid}/edit','RemarksController@edit');

Route::post('/remarks/delete','RemarksController@delete');

Route::post('/remarks/update','RemarksController@update');

// Antonio - Entreprises list
Route::get('/entreprises', 'EntreprisesController@index');
Route::post('/entreprises/add', 'EntreprisesController@add');
Route::post('/entreprises/filter', 'EntreprisesController@filter');

// Antonio - Entreprise details
Route::get('/entreprise/{id}', 'EntrepriseController@index');
Route::get('/entreprise/{id}/remove', 'EntrepriseController@remove');
Route::post('/entreprise/{id}/save', 'EntrepriseController@save');
Route::post('/entreprise/addRemarks', 'EntrepriseController@addRemarks');


// Quentin N - Contract generation
Route::get('/contract/{iid}', 'ContractController@generateContract');

Route::post('/contract/{iid}/view', 'ContractController@visualizeContract');

Route::post('/contract/{iid}/save', 'ContractController@saveContract');

Route::get('/contract/{iid}/cancel', 'ContractController@cancelContract');

// Steven

Route::get('/synchro', 'SynchroController@index');

Route::post('/synchro/modify', 'SynchroController@modify');

// Jean-Yves
Route::get('/visits','VisitsController@index');
Route::post('/visits', 'VisitsController@changeFilter');
Route::get('/visits/{rid}/manage','VisitsController@manage');
Route::post('/visits/create','VisitsController@create');
Route::get('/visits/{id}/mail','VisitsController@mail');
Route::get('/visits/{id}/delete', 'VisitsController@delete');
Route::post('/visits/{id}/update', 'VisitsController@update');

// Add by Benjamin Delacombaz 12.12.2017 10:40
Route::get('/wishesMatrix', 'WishesMatrixController@index');
// Add by Benjamin Delacombaz 21.01.2018
Route::post('/wishesMatrix', 'WishesMatrixController@save');

// Kevin
Route::get('/traveltime/{flockId}/load', 'TravelTimeController@load');
Route::get('/traveltime/{flockId}/calculate', 'TravelTimeController@calculate');


/**
 * Bastien - Evaluation grid
 * 
 * All the routes to interact with the evaluation Grid (edition)
 * Grouped by the /evalgrid prefix
 */
Route::prefix('evalgrid')->group(function () {

    /**
     * Home page of the section (just for dev)
     */
    Route::get('evalgrid', 'EvalController@index')->name('evalGridHome');
    /**
     * Create a new evaluation linked to a visit
     * @param visit the visit id
     */
    Route::get('neweval/{visit}', 'EvalController@newEval')->where('visit', '[0-9]+')->name('newEvalGrid');
    /**
     * Display an evaluation grid for edition or reading
     * @param mode 'readonly' or 'edit'
     * @param gridID the id of the grid we want to edit. OPTIONAL parameter (we can also pass the id by the session with the 'activeEditedGrid' key)
     */
    Route::get('grid/{mode}/{gridID}', 'EvalController@editEval')->where(['mode' => 'edit|readonly', 'gridID' => '[0-9]+'])->name('editEvalGrid');
    /**
     * Edit the values of the grid fields (see the controller method for more infos)
     */
    Route::post('grid/save/{gridID}', 'EvalController@saveNewGridDatas')->where(['gridID' => '[0-9]+'])->name('saveNewGridDatas');
});

// Nicolas - Stages
Route::get('/reconstages', 'ReconStagesController@index');
Route::post('/reconstages/reconmade', 'ReconStagesController@reconStages');
// Nicolas - Documents
Route::get('/documents', 'DocumentsController@index');

// Davide
Route::get('/listPeople', 'PeopleControlleur@index');
Route::post('/listPeople/category', 'PeopleControlleur@category');
Route::get('/listPeople/{id}/info','PeopleControlleur@info');
Route::post('/listPeople/update/{id}','PeopleControlleur@update');

//


//Julien - Grille d'évaluation - Modélisation
Route::get('/editGrid', 'EditGridController@index');
Route::post('/editGrid/editCriteria', 'EditGridController@editCriteria');
Route::post('/editGrid/editSection', 'EditGridController@editSection');
Route::post('/editGrid/removeCriteria', 'EditGridController@removeCriteria');
Route::post('/editGrid/removeSection', 'EditGridController@removeSection');
Route::post('/editGrid/addCriteria', 'EditGridController@addCriteria');
Route::post('/editGrid/addSection', 'EditGridController@addSection');