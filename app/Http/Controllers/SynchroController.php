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
use App\Persons;

class SynchroController extends Controller
{
    private $goodStudents = [];
    private $obsoleteStudents = [];
    private $newStudents = [];
    private $updateStudents = [];
    private $message;

    protected function dbObsoleteFunction()
    {
        foreach($this->obsoleteStudents as $obsoletStudent)
        {
            $student = Persons::where('intranetUserId', $obsoleteStudent->intranetUserId);
            if($student->obsolete != 1)
            {
                $student->obsolete = 1;
            }

            $student->save();
        }
    }

    protected function dbNewFunction()
    {
        foreach($this->newStudents as $newStudent)
        {
            $student = new Persons;

            $student->firstname = $newStudent['firstname'];
            $student->lastname = $newStudent['lastname'];
            $student->upToDateDate = $newStudent['updatedOn'];
            $student->intranetUserId = $newStudent['id'];

            $student->save();
        }
    }

    public function all()
    {
        $this->dbObsoleteFunction();
        $this->dbNewFunction();

        $this->message = "Modifications nécessaires ont été synchronisées";
        return $this->index();
    }

    public function delete()
    {
        $this->dbObsoleteFunction();

        $this->message = "Modifications nécessaires ont été synchronisées";
        return $this->index();
    }

    public function new()
    {
        $this->dbNewFunction();

        $this->message = "Modifications nécessaires ont été synchronisées";
        return $this->index();
    }

    public function index()
    {
        $dbStudents = Persons::all();
        $dbStudents = $dbStudents->sortBy('lastname');
        $intranetStudents = new Connection();
        $studentsList = $intranetStudents->getStudents();

        foreach($dbStudents as $student)
        {
            if(in_array($student->intranetUserId, array_column($studentsList, 'id')))
            {
                if(in_array($student->upToDateDate, array_column($studentsList, 'UpdatedOn')))
                {
                    array_push($this->goodStudents, $student);
                }
                else
                {
                    array_push($this->updateStudents, $student);
                }
            }
            else
            {
                array_push($this->obsoleteStudents, $student);
            }
        }

        foreach($studentsList as $student)
        {
            if(!$dbStudents->contains('intranetUserId', $student['id']))
            {
                array_push($this->newStudents, $student);
            }
        }

        usort($this->newStudents,function($a,$b) {return strnatcasecmp($a['lastname'],$b['lastname']);});


        return view('synchro/index')->with([ 'goodStudents' => $this->goodStudents, 'obsoleteStudents' => $this->obsoleteStudents, 'newStudents' => $this->newStudents, 'updateStudents' => $this->updateStudents]);
    }
}