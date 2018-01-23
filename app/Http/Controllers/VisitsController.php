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
use CPNVEnvironment\Environment;
use Illuminate\Support\Facades\DB;

class VisitsController extends Controller
{
    private $message = '';

    /* In main page of visits, return list of visits */
    public function index()
    {
        // Check if the user is a superuser
        // We grant him access to visits if he has access
        if (Environment::currentUser()->getLevel() < 5){ // ! ! ! Let the access for developpment, but need to put it at >1

            // Query get visits
            $internships = Visit::join('internships', 'visits.internships_id', '=', 'internships.id')
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

        //If not a superuser, we redirect him to home page
        else{
            return redirect('/')->with('status', "You don't have the permission to access this function.");
        }
    }

    // Function return data from a visit.
    public function manage (Request $request, $rid) {

        // Query get a specify visit
        $internship = Visit::join('internships', 'visits.internships_id', '=', 'internships.id')
        ->join('persons', 'internships.intern_id', '=', 'persons.id')
        ->join('companies', 'internships.companies_id', '=', 'companies.id')
        ->join('visitsstates', 'visits.visitsstates_id', '=', 'visitsstates.id')
        ->select('visits.id','internships_id', 'visitsstates_id', 'companyName', 'beginDate', 'endDate' ,'moment', 'firstname', 'lastname', 'stateName', 'mailstate', 'internships.responsible_id', 'grade')
        ->where('visits.id', $rid)
        ->first();

        //get info from intern's responsible
        $contact = DB::table('internships')
        ->join('persons', 'internships.responsible_id' ,'=', 'persons.id')
        ->join('contactinfos', 'persons.id', '=', 'contactinfos.persons_id')
        ->select('value', 'responsible_id', 'contacttypes_id')
        ->where('responsible_id', $internship->responsible_id)
        ->where('contacttypes_id', '=', 1)
        ->first();

        //get status of the internship
        $visitstate = DB::table('visitsstates')
        ->where('id', '<=', 2)
        ->get();

        return view('visits/manage')->with(
            [
                'internship' => $internship,
                'contact' => $contact,
                'visitstate' => $visitstate
            ]
        );
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

    /* Function update schedule */
    public function update(Request $request, $id)
    {
        $state = $request->input('state');
        $date = $request->upddate;
        $date .= " ".$request->updtime;
        $mail = $request->input('selm');

        if($state == 1 )
        {
            Visit::where('visits.id', '=', $id)
                ->update([
                    'visitsstates_id' => $state,
                    'moment' => $date,
                    'mailstate' => $mail,
                ]);
        }

        else
        {
            Visit::where('visits.id', '=', $id)
                ->update([
                    'visitsstates_id' => $state,
                    'moment' => $date,
                    'mailstate' => $mail,
                ]);
        }

        $this->message = 'La visite a été modifiée !';
        return $this->index();
    }

    /**
     * Build list of internships that match the filter - and display it
     * @param InternshipFilter $ifilter
     * @return $this
     */
    private function filteredInternships(InternshipFilter $ifilter)
    {
        $states = $ifilter->getStateFilter();
        // build list of ids to select by internship state
        foreach ($states as $state)
            if ($state->checked)
                $idlist[] = $state->id;
        if (isset($idlist))
            $iships = DB::table('internships')
                ->join('companies', 'companies_id', '=', 'companies.id')
                ->join('persons as admresp', 'admin_id', '=', 'admresp.id')
                ->join('persons as intresp', 'responsible_id', '=', 'intresp.id')
                ->join('persons as student', 'intern_id', '=', 'student.id')
                ->join('contractstates', 'contractstate_id', '=', 'contractstates.id')
                ->join('flocks', 'student.flock_id', '=', 'flocks.id')
                ->join('persons as mc', 'classMaster_id', '=', 'mc.id')
                ->select(
                    'internships.id',
                    'beginDate',
                    'endDate',
                    'companyName',
                    'admresp.firstname as arespfirstname',
                    'admresp.lastname as aresplastname',
                    'intresp.firstname as irespfirstname',
                    'intresp.lastname as iresplastname',
                    'student.firstname as studentfirstname',
                    'student.lastname as studentlastname',
                    'mc.intranetUserId as mcid',
                    'mc.initials as mcini',
                    'contractstate_id',
                    'stateDescription')
                ->whereIn('contractstate_id', $idlist)
                ->get();
        else
            $iships = array();
        switch ($ifilter->getMine() * 2 + $ifilter->getInProgress())
        {
            case 1:
                $keepOnly = self::getCurrentInternships();
                break;
            case 2:
                $keepOnly = self::getMyInternships();
                break;
            case 3:
                $keepOnly = self::getMyCurrentInternships();
        }
        if (isset($keepOnly))
        {
            $finallist = array();
            foreach ($iships as $iship)
                if (array_search($iship->id, $keepOnly))
                    $finallist[] = $iship;
        } else
            $finallist = $iships;
        return view('internships/internships')->with('iships', $finallist)->with('filter', $ifilter);
    }

    /**
     * Returns a list (array of ids, sorted ascending) of internships where the current user was MC
     */
    public static function getMyInternships()
    {
        $iships = DB::table('internships')
            ->join('persons as student', 'intern_id', '=', 'student.id')
            ->join('flocks', 'student.flock_id', '=', 'flocks.id')
            ->join('persons as mc', 'classMaster_id', '=', 'mc.id')
            ->select('internships.id')
            ->where('mc.intranetUserId', '=', $me = Environment::currentUser()->getId())
            ->orderBy('internships.id', 'asc')
            ->get();
        $res = array();
        foreach ($iships as $iship) $res[] = $iship->id;
        return $res;
    }
/*
    public function changeFilter(Request $request)
    {
        // Get states from db (to have descriptions)
        $filter = DB::table('contractstates')->select('id', 'stateDescription')->get();
        // patch list with values from post
        foreach ($filter as $state)
        {
            $state->checked = false;
            foreach ($request->all() as $fname => $fval)
                if (substr($fname, 0, 5) == 'state')
                    if ($state->id == intval(substr($fname, 5)))
                        $state->checked = ($fval == 'on');
        }

        Cookie::queue('filter', serialize($filter), 3000);

        return $this->filteredInternships($filter);
    }

    private function filteredInternships($filter)
    {
        // build list of ids to select
        foreach ($filter as $state)
            if ($state->checked)
                $idlist[] = $state->id;

        if (isset($idlist))
            $iships = DB::table('internships')
                ->join('companies', 'companies_id', '=', 'companies.id')
                ->join('persons as admresp', 'admin_id', '=', 'admresp.id')
                ->join('persons as intresp', 'responsible_id', '=', 'intresp.id')
                ->join('persons as student', 'intern_id', '=', 'student.id')
                ->join('contractstates', 'contractstate_id', '=', 'contractstates.id')
                ->select(
                    'internships.id',
                    'beginDate',
                    'companyName',
                    'admresp.firstname as arespfirstname',
                    'admresp.lastname as aresplastname',
                    'intresp.firstname as irespfirstname',
                    'intresp.lastname as iresplastname',
                    'student.firstname as studentfirstname',
                    'student.lastname as studentlastname',
                    'contractstate_id',
                    'stateDescription')
                ->whereIn('contractstate_id', $idlist)
                ->get();
        else
            $iships = array();

        return view('internships/internships')->with('iships', $iships)->with('statefilter', $filter);
    }*/
}