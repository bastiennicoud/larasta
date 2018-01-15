<?php

/*
 * Title: VisitsController.php
 * Author: Jean-Yves Le
 * Creation date : 12 Dec 2017
 * Modification date : 15 janvier 2018
 * Version : 0.4
 * */


namespace App\Http\Controllers;


use App\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VisitsController extends Controller
{
    private $message = '';

    /* In main page of visits, return list of visits */
    public function index()
    {
        // Query
        $internships = DB::table('visits')
        ->join('internships', 'visits.internships_id', '=', 'internships.id')
        ->join('persons', 'internships.intern_id', '=', 'persons.id')
        ->join('companies', 'internships.companies_id', '=', 'companies.id')
        ->join('visitsstates', 'visits.visitsstates_id', '=', 'visitsstates.id')
        ->select('visits.id' ,'persons.firstname', 'persons.lastname', 'companyName', 'stateName', 'beginDate', 'endDate', 'mailstate')
        ->orderBy('visits.id', 'DESC')
        ->limit(30)
        ->get();

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
        ->select('visits.id','internships_id', 'visitsstates_id', 'companyName', 'beginDate', 'endDate' ,'moment', 'firstname', 'lastname', 'stateName', 'mailstate', 'internships.responsible_id', 'grade')
        ->where('visits.id', $rid)
        ->first();

        $contact = DB::table('internships')
        ->join('persons', 'internships.responsible_id' ,'=', 'persons.id')
        ->join('contactinfos', 'persons.id', '=', 'contactinfos.persons_id')
        ->select('value', 'responsible_id', 'contacttypes_id')
        ->where('responsible_id', $internship->responsible_id)
        ->where('contacttypes_id', '=', 1)
        ->first();


        $log = DB::table('logbooks')
            ->join('activitytypes', 'logbooks.activitytypes_id', '=', 'activitytypes.id')
            ->where('internships_id' , '=', $rid)
            ->select('activitytypes.id', 'internships_id', 'entryDate', 'activityDescription', 'typeActivityDescription')
            ->orderBy('entryDate', 'DESC')
            ->get();

        error_log(print_r($contact, 1));
        //dd($rid);

        return view('visits/manage')->with(
            [
                'internship' => $internship,
                'contact' => $contact,
                'log' => $log
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


    /* Function redirects user and update states in internships */
    public function mail(Request $request, $id)
    {
        Visit::where('internships_id', '=', $id)
        ->update([
            'visitsstates_id' => 2,
            'mailstate' => 1
        ]);

        $this->message = 'Etat de la visite a été modifié !';
        return $this->index();
    }


    /* Function deletes a visit*/
    public function delete(Request $request, $id)
    {
        Visit::where('id', '=', $id)
        ->delete();

        $this->message = 'Visite supprimée !';
        return $this->index();
    }

    public function logbook()
    {

    }
}
