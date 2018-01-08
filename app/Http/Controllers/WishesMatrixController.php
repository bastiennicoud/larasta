<?php
//------------------------------------------------------------
// Benjamin Delacombaz
// version 0.2
// WishesMatrixController
// Created 18.12.2017
// Last edit 08.01.2017 by Benjamin Delacombaz
//------------------------------------------------------------

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Companies;

class WishesMatrixController extends Controller
{
    public function index()
    {
        $companies = $this->getCompanies();
        $persons = $this->getPersons(12);
        $wishes = null;
        
        // Get all wishes per person
        foreach ($persons as $person)
        {
            $wishes[$person->id] = $this->getWishesByPersons($person->id);
        }

        return view('wishesMatrix/wishesMatrix')->with(['companies' => $companies, 'persons' => $persons, 'wishes' => $wishes]);
    }

    private function getCompanies()
    {
        // Get all the companies where mptOk equals 1
        $companies = DB::table('companies')
            ->where('companies.mptOK', 1)
            ->select('companies.companyName')
            ->get();
        return $companies;
    }

    private function getPersons($flock_id)
    {
        $persons = DB::table('persons')
            ->where('persons.flock_id', $flock_id)
            ->select('persons.id','persons.initials')
            ->get();
        return $persons;
    }

    //Tests

    // in Progress
    private function getWishesByPersons($idPerson)
    {
        $wishes = DB::table('wishes')
            ->join('internships', 'wishes.internships_id', '=', 'internships.id')
            ->join('companies', 'internships.companies_id', '=', 'companies.id')
            ->where('wishes.persons_id', $idPerson)
            ->where('wishes.rank', '>', 0)
            ->select('wishes.rank', 'wishes.internships_id', 'companies.companyName')
            ->get();
        return $wishes;
    }

    // Dead
    private function getPersonsAndWhishes($flock_id)
    {
        $persons = DB::table('persons')
            ->join('wishes', 'persons_id', '=', 'persons.id')
            ->join('internships', 'internships_id', '=', 'internships.id')
            ->where('persons.flock_id', $flock_id)
            ->where('wishes.rank','>',1)
            ->select('persons.id','persons.initials')
            ->get();
        return $persons;
    }
}
