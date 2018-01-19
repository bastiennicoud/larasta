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
use App\Flock;

class SynchroController extends Controller
{
    private $goodPersons = [];
    private $obsoletePersons = [];
    private $newPersons = [];
    private $classesList;

    protected function dbObsoletePersons($personIntranetId)
    {
        $person = Persons::where('intranetUserId', $personIntranetId);
        $person->obsolete = 1;

        $person->save();
    }

    protected function dbNewPersons($personIndex)
    {
        $person = new Persons;

        $person->firstname = $this->newPersons[$personIndex]['firstname'];
        $person->lastname = $this->newPersons[$personIndex]['lastname'];
        $person->upToDateDate = $this->newPersons[$personIndex]['updated_on'];
        $person->intranetUserId = $this->newPersons[$personIndex]['id'];
        if ($this->newPersons[$personIndex]['occupation'] == "Elève" || $this->newPersons[$personIndex]['occupation'] == "Eleve")
        {
            $person->role = 0;
        }
        else
        {
            $person->role = 1;
        }
    
        $person->save();
    }

    protected function dbNewClasses($personIndex)
    {
        if (Persons::where('intranetUserId', $this->newPersons[$personIndex]['id'])->where('role', 0)->exists())
        {
            $person = Persons::where('intranetUserId', $this->newPersons[$personIndex]['id'])->where('role', 0)->first();
            $dateSplit = explode('-', $this->newPersons[$personIndex]['updated_on']);
            $flockId = $this->checkFlock($dateSplit[0], $this->newPersons[$personIndex]['current_class']['link']['name']);

            $person->flock_id = $flockId;

            $person->save();
        }
    }

    public function addFlock($startYear, $className)
    {
        $flock = new Flock;

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
        /*$dateSys = date('Y-M-D');
        $classSplit = str_split($className);
        $classYear = intval($classSplit[4]);

        if ($dateSys->format('M') >= 8)
        {
            $startYear = $dateSys->format('Y') - $classYear;
        }
        else
        {
            $startYear = $dateSys->format('Y') - $classYear - 1;
        }*/

        if (Flock::where('startYear', $startYear)->exists())
        {
            $flocks = Flock::where('startYear', $startYear)->get();
            
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

    public function modify(Request $request)
    {
        $this->getDatas();

        if ($request->modify == "add")
        {
            foreach ($request->addCheck as $personIndex)
            {
                $this->dbNewPersons(intval($personIndex));
            }

            foreach ($request->addCheck as $personIndex)
            {
                $this->dbNewClasses(intval($personIndex));
            }
        }
        else if ($request->modify == "delete")
        {
            foreach ($request->deleteCheck as $personIntranetId)
            {
                $this->dbObsoletePersons($personIntranetId);
            }
        }

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

        usort($this->newPersons,function($a,$b) {return strnatcasecmp($a['lastname'],$b['lastname']);});
    }

    public function index()
    {
        $this->getDatas();

        return view('synchro/index')->with([ 'goodStudents' => $this->goodPersons, 'obsoleteStudents' => $this->obsoletePersons, 'newStudents' => $this->newPersons]);
    }
}