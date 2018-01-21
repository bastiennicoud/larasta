<?php
//------------------------------------------------------------
// Benjamin Delacombaz
// version 0.6
// WishesMatrixController
// Created 18.12.2017
// Last edit 21.01.2017 by Benjamin Delacombaz
//------------------------------------------------------------

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Companies;
use SebastianBergmann\Environment\Console;
use function GuzzleHttp\json_encode;
use CPNVEnvironment\Environment;

class WishesMatrixController extends Controller
{
    public function index()
    {
        // !!!!!!!!!!!! Test Value !!!!!!!!!!!!!!!!!!!!!!!!!!
        $currentUserTest = Environment::currentUser();
        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        $currentUser = $this->getCurrentUser($currentUserTest->getId());
        $companies = $this->getCompaniesWithInternships();
        $persons = $this->getPersons($currentUser->flock_id);
        $wishes = null;
        $dateEndWishes =  null;
        
        // Get all wishes per person
        foreach ($persons as $person)
        {
            $wishes[$person->id] = $this->getWishesByPerson($person->id);
        }

        // Get info for teacher
        // Test if current user is a teacher
        if($currentUser->role >= 1)
        {
            $param = \App\Params::getParamByName('dateEndWishes');
            if($param != null)
            {
                // Convert the date/time to date only
                $dateEndWishes = date('Y-m-d', strtotime($param->paramValueDate));   
            }
        }
        return view('wishesMatrix/wishesMatrix')->with(['companies' => $companies, 'persons' => $persons, 'wishes' => $wishes, 'currentUser' => $currentUser, 'dateEndWishes' => $dateEndWishes]);
    }

    public function save()
    {
        echo "Test de ouf";
    }

    private function getCompaniesWithInternships()
    {
        // Get all the companies where mptOk equals 1
        $companies = DB::table('companies')
            ->join('internships', 'internships.companies_id', '=', 'companies.id')
            ->where('companies.mptOK', 1)
            ->whereYear('internships.beginDate', '=', date('Y'))
            ->select('companies.id','companies.companyName')
            ->get();
        return $companies;
    }

    private function getPersons($flock_id)
    {
        $persons = DB::table('persons')
            ->where('persons.flock_id', $flock_id)
            ->whereNotNull('persons.initials')
            ->select('persons.id','persons.initials')
            ->get();
        return $persons;
    }

    private function getWishesByPerson($idPerson)
    {
        $wishes = DB::table('wishes')
            ->join('internships', 'wishes.internships_id', '=', 'internships.id')
            ->join('companies', 'internships.companies_id', '=', 'companies.id')
            ->where('wishes.persons_id', $idPerson)
            ->where('wishes.rank', '>', 0)
            ->select('wishes.rank', 'wishes.internships_id', 'companies.companyName', 'companies.id')
            ->get();
        return $wishes;
    }

    private function getCurrentUser($personId)
    {
        $persons = DB::table('persons')
            ->where('persons.id', $personId)
            ->whereNotNull('persons.initials')
            ->select('persons.id','persons.initials', 'persons.flock_id', 'persons.role')
            ->first();
        return $persons;
    }
}
