<?php

/*
 * Title: VisitsController.php
 * Author: Jean-Yves Le
 * Creation date : 12 Dec 2017
 * Modification date : 09 janvier 2018
 * Version : 1.3
 *
 * */


namespace App\Http\Controllers;


use App\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitsController extends Controller
{
    private $message = '';

    public function index()
    {
        $internships = DB::table('visits')
        ->join('internships', 'visits.internships_id', '=', 'internships.id')
        ->join('persons', 'internships.intern_id', '=', 'persons.id')
        ->join('companies', 'internships.companies_id', '=', 'companies.id')
        ->join('visitsstates', 'visits.visitsstates_id', '=', 'visitsstates.id')
        ->select('visits.id' ,'persons.firstname', 'persons.lastname', 'companyName', 'stateName', 'beginDate', 'endDate', 'mailstate')
        ->groupby('visits.id')
        ->orderBy('visits.id', 'DESC')
        ->limit(30)
        ->get();

        //error_log(print_r($internships, 1));

        return view('visits/visits')->with(
            [
                'internships' => $internships,
                'message' => $this->message
            ]
        );
    }

    public function manage (Request $request, $rid) {

        $internship = Visit::
        join('internships', 'visits.internships_id', '=', 'internships.id')
        ->join('persons', 'internships.intern_id', '=', 'persons.id')
        ->join('companies', 'internships.companies_id', '=', 'companies.id')
        ->join('visitsstates', 'visits.visitsstates_id', '=', 'visitsstates.id')
        ->select('visits.id','internships_id', 'companyName', 'beginDate', 'endDate' ,'moment', 'firstname', 'lastname', 'stateName', 'mailstate')
        ->where('visits.id', $rid)
        ->first();

        $contact = DB::table('internships')
        ->join('persons', 'internships.responsible_id' ,'=', 'persons.id')
        ->join('contactinfos', 'persons.id', '=', 'contactinfos.persons_id')
        ->join('companies', 'persons.company_id' ,'=', 'companies.id')
        ->select('value')
        ->where('companies_id', 39)
        ->where('responsible_id', 186)
        ->first();

        error_log(print_r($contact, 1));
        //dd($rid);

        return view('visits/manage')->with(
            [
                'internship' => $internship,
                'contact' => $contact
            ]
        );
    }

    public function add() {

        $internships = DB::table('visits')->get();

        //error_log(print_r($internships, 1));

        return view('visits/add')->with(
            [
                'internships' => $internships
            ]
        );
    }

    public function create(Request $request) {
        $visit = new Visit();
        $visit->moment = $request->date;
        $visit->number = $request->number;
        $visit->internships_id = $request->internship;
        $visit->visitsstates_id = 2;
        $visit->save();
        $this->message = 'Remarque ajoutée';

        return $this->index();
    }

    public function mail(Request $request, $id)
    {
        //dd($id);
        Visit::where('internships_id', '=', $id)
        ->update([
            'visitsstates_id' => 2,
            'mailstate' => 1
        ]);

        //dd($rid);
        //$this->message = $rid;
        $this->message = 'Etat de la visite a été modifié !';
        return $this->index();
    }
}
