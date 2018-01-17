<?php
/*
 * Title : SynchroController.php
 * Author : Steven Avelino
 * Creation Date : 12 December 2017
 * Modification Date : 15 January 2017
 * Version : 0.3
 * Controller for the Synchronisation between the intranet API and this application
*/

namespace App\Http\Controllers;

use App\IntranetConnection as Connection;
use Illuminate\Http\Request;
use App\Persons;
use App\Flocks;

class SynchroController extends Controller
{
    private $goodPersons = [];
    private $obsoletePersons = [];
    private $newPersons = [];
    private $classesList;

    public function dbObsoleteTest()
    {
        foreach ($this->obsoletePersons as $obsoletePerson)
        {
            $person = Persons::where('intranetUserId', $obsoletePerson->intranetUserId)->first();
            $person->obsolete = 1;
    
            $person->save();
        }
    }

    public function dbNewTest()
    {
        foreach ($this->newPersons as $newPerson)
        {
            $person = new Persons;

            $person->firstname = $newPerson['firstname'];
            $person->lastname = $newPerson['lastname'];
            $person->upToDateDate = $newPerson['updated_on'];
            $person->intranetUserId = $newPerson['id'];
            if ($newPerson['occupation'] == "Elève" || $newPerson['occupation'] == "Eleve")
            {
                $person->role = 0;
            }
            else
            {
                $person->role = 1;
            }
    
            $person->save();
        }

        foreach ($this->newPersons as $newPerson)
        {
            if (Persons::where('intranetUserId', $newPerson['id'])->where('role', 0)->exists())
            {
                $person = Persons::where('intranetUserId', $newPerson['id'])->where('role', 0)->first();
                $dateSplit = explode('-', $newPerson['updated_on']);
                $flockId = $this->checkFlock($dateSplit[0], $newPerson['current_class']['link']['name']);

                $person->flock_id = $flockId;

                $person->save();
            }
        }
    }

    protected function dbObsoleteFunction($person)
    {
        $person = Persons::where('intranetUserId', $obsoletPerson->intranetUserId);
        $person->obsolete = 1;

        $person->save();
    }

    protected function dbNewFunction($person)
    {
        $person = new Persons;

        $person->firstname = $newPerson['firstname'];
        $person->lastname = $newPerson['lastname'];
        $person->upToDateDate = $newPerson['updatedOn'];
        $person->intranetUserId = $newPerson['id'];
        if ($newPerson['occupation'] == "Elève")
        {
            $person->role = 0;
            $dateSplit = explode('-', $newPerson['updatedOn']);
            $person->flock_id = $this->checkFlock($dateSplit[0], $newPerson['current_class']['link']['name']);
        }
        else if ($newPerson['occupation'] == "Enseignant")
        {
            $person->role = 1;
        }

        $person->save();
    }

    public function addFlock($startYear, $className)
    {
        $flock = new Flocks;

        $flock->flockName = $className . $startYear;
        $flock->startYear = $startYear;

        foreach($this->classesList as $classe)
        {
            if ($classe['name'] == $className)
            {
                if ($classe['master'] != null) {
                    $person = Persons::where('intranetUserId', $classe['master']['link']['id'])->first();
                    $flock->classMaster_id = $person->id;
                }
            }
        }

        $flock->save();

        return $flock->id;
    }

    public function checkFlock($startYear, $className)
    {
        $dateSys = date('Y-M-D');
        $classSplit = str_split($className);
        $classYear = intval($classSplit[4]);

        if ($dateSys->format('M') >= 8)
        {
            $startYear = $dateSys->format('Y') - $classYear;
        }
        else
        {
            $startYear = $dateSys->format('Y') - $classYear - 1;
        }

        if (Flocks::where('startYear', $startYear)->exists())
        {
            $flocks = Flocks::where('startYear', $startYear)->get();
            
            foreach ($flocks as $flock)
            {
                if ($flock->flockName == $className . $startYear)
                {
                    return $flock->id;
                }
            }

            return $this->addFlock($startYear, $className, $this->classesList);
        }
        else
        {
            return $this->addFlock($startYear, $className, $this->classesList);   
        }

    }

    public function all()
    {
        $this->dbObsoleteFunction();
        $this->dbNewFunction();

        return redirect('/synchro');
    }

    public function delete(Request $request)
    {
        /*$checkboxes = $request->input('checkbox');

        foreach ($checkboxes as $person)
        {
            $this->dbObsoleteFunction($person);
        }*/

        $this->getDatas();

        $this->dbObsoleteTest();

        $request->session()->flash('status', 'Personnes obsolètes supprimées');
        return redirect('/synchro');
    }

    public function new(Request $request)
    {
        /*$checkboxes = $request->input('checkbox');

        foreach ($checkboxes as $person)
        {
            $this->dbNewFunction($person);
        }*/

        $this->getDatas();

        $this->dbNewTest();

        $request->session()->flash('status', 'Nouvelles personnes ajoutées');
        return redirect('/synchro');
    }

    public function getDatas()
    {
        $dbStudents = Persons::all();
        $dbStudents = $dbStudents->sortBy('lastname');
        $intranetStudents = new Connection("students");
        $intranetTeachers = new Connection("teachers");
        $intranetClasses = new Connection("classes");
        $this->classesList = $intranetClasses->getClasses();
        $studentsList = $intranetStudents->getStudents();
        $teachersList = $intranetTeachers->getTeachers();
        $personsList = array_merge($studentsList, $teachersList);

        foreach($dbStudents as $student)
        {
            if(in_array($student->intranetUserId, array_column($personsList, 'id')))
            {
                array_push($this->goodPersons, $student);
            }
            else
            {
                if ($student->obsolete == 0)
                {
                    array_push($this->obsoletePersons, $student);
                }
            }
        }

        foreach($personsList as $person)
        {
            if(!$dbStudents->contains('intranetUserId', $person['id']))
            {
                array_push($this->newPersons, $person);
            }
        }
    }

    public function index()
    {
        $this->getDatas();

        usort($this->newPersons,function($a,$b) {return strnatcasecmp($a['lastname'],$b['lastname']);});


        return view('synchro/index')->with([ 'goodStudents' => $this->goodPersons, 'obsoleteStudents' => $this->obsoletePersons, 'newStudents' => $this->newPersons]);
    }
}