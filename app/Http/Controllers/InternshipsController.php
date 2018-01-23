<?php


namespace App\Http\Controllers;

use App\Contractstates;
use App\Internships;
use Carbon\Carbon;
use CPNVEnvironment\Environment;
use CPNVEnvironment\InternshipFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class InternshipsController extends Controller
{
    // index, base route
    /**
     * Retrieve filtering criteria from cookie, creat an empty one if needed
     *
     * @param Request $request
     * @return $this
     */
    public function index(Request $request)
    {
        $ifilter = new InternshipFilter();
        // Retrieve filter conditions from cookie (or initialize them from database)
        $cookie = $request->cookie('filter');
        if ($cookie == null)
            return $this->changeFilter($request);
        else
            $ifilter = unserialize($cookie);

        return $this->filteredInternships($ifilter);
    }

    /**
     * Some filtering parameter has changed (or filter is empty)
     *
     * @param Request $request
     * @return $this
     */
    public function changeFilter(Request $request)
    {
        $ifilter = new InternshipFilter();

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
            $list[] = $state;
        }
        $ifilter->setStateFilter($list);

        // Handle cases that are not states rom the database
        $ifilter->setInProgress(isset($request->all()['inprogress']) ? 1 : 0);
        $ifilter->setMine(isset($request->all()['mine']) ? 1 : 0);

        Cookie::queue('filter', serialize($ifilter), 3000);

        return $this->filteredInternships($ifilter);
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
                ->join('flocks','student.flock_id','=','flocks.id')
                ->join('persons as mc','classMaster_id','=','mc.id')
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

        // Mark unwanteds because not mine
        if ($ifilter->getMine())
            for ($i=0; $i < count($iships); $i++)
                if ($iships[$i]->mcid != Environment::currentUser()->getId())
                    $iships[$i]->id = -1;

        // Mark unwanteds because not current
        if ($ifilter->getInProgress())
            for ($i=0; $i < count($iships); $i++)
                if ($iships[$i]->beginDate > date('Y-m-d') || $iships[$i]->endDate < date('Y-m-d'))
                    $iships[$i]->id = -1;

        // Pack result: rebuild array skipping unwanteds
        $finallist = array();
        foreach($iships as $iship)
            if ($iship->id > 0)
                $finallist[] = $iship;

        return view('internships/internships')->with('iships', $finallist)->with('filter', $ifilter);
    }

    public function edit($iid)
    {
        $iship = DB::table('internships')
            ->join('companies', 'companies_id', '=', 'companies.id')
            ->join('persons as admresp', 'admin_id', '=', 'admresp.id')
            ->join('persons as intresp', 'responsible_id', '=', 'intresp.id')
            ->join('persons as student', 'intern_id', '=', 'student.id')
            ->join('contractstates', 'contractstate_id', '=', 'contractstates.id')
            ->join('flocks', 'student.flock_id', '=', 'flocks.id')
            ->join('persons as mc', 'flocks.classMaster_id', '=', 'mc.id')
            ->select(
                'internships.id',
                'beginDate',
                'endDate',
                'companyName',
                'grossSalary',
                'mc.initials',
                'previous_id',
                'internshipDescription',
                'admresp.firstname as arespfirstname',
                'admresp.lastname as aresplastname',
                'intresp.firstname as irespfirstname',
                'intresp.lastname as iresplastname',
                'student.firstname as studentfirstname',
                'student.lastname as studentlastname',
                'contractstate_id',
                'contractGenerated',
                'stateDescription')
            ->where('internships.id','=', $iid)
            ->first();

        return view('internships/internship')->with('iship', $iship);
    }
}
