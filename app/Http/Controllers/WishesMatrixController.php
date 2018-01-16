<?php
//------------------------------------------------------------
// Benjamin Delacombaz
// version 0.3
// WishesMatrixController
// Created 18.12.2017
// Last edit 09.01.2017 by Benjamin Delacombaz
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
        // Complete the session for test

        $currentUser = Environment::currentUser();
        $flockId = 12;
        $currentInitial = "CRY";
        $companies = $this->getCompaniesWithInternships();
        $persons = $this->getPersons($flockId);
        $wishes = null;

        echo $currentUser->getInitials();
        
        // Get all wishes per person
        foreach ($persons as $person)
        {
            $wishes[$person->id] = $this->getWishesByPerson($person->id);
        }
        return view('wishesMatrix/wishesMatrix')->with(['companies' => $companies, 'persons' => $persons, 'wishes' => $wishes, 'currentInitial' => $currentInitial, 'currentUser' => $currentUser, 'flockId' => $flockId]);
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
}
