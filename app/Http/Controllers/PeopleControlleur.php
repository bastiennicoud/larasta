<?php
/**
 * Created by PhpStorm.
 * User: Davide.CARBONI
 * Date: 18.12.2017
 * Time: 09:06
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persons;

class PeopleControlleur extends Controller
{
    // index, base route
    public function index()
    {
        $persons = Persons::all();
        //dd($persons->role);
        return view('listPeople/people')->with(
            [
                'persons' => $persons
            ]
        );
    }
}