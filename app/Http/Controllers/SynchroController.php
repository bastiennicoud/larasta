<?php
/*
 * Title : SynchroController.php
 * Author : Steven Avelino
 * Creation Date : 12 December 2017
 * Modification Date : 16 December 2017
 * Version : 0.1
 * Controller for the Synchronisation between the intranet API and this application
*/

namespace App\Http\Controllers;

use App\IntranetConnection as Connection;

class SynchroController extends Controller
{
    public function index()
    {
        $students = new Connection();

        $studentsList = $students->getStudents();

        return view('synchro/index')->with([ 'students' => $studentsList]);
    }
}