<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Params;

class ReconStagesController extends Controller
{
    // index, base route
    public function index()
    {
        $internsiphs = $this->getInternships();
        return view('reconstages/reconstages')->with(
            [
                "internsiphs" => $internsiphs
            ]
        );
    }

    public function displayStages()
    {
        return view('reconstages/reconmade');
    }


    public function getInternships(){

        foreach(Params::all() as $param)
        {
            if($param->paramName == "reconductible")
            {
                $selectable[] = $param->paramValueInt;
            }
        }

        $internsiphs = DB::table('internships')
        ->join('companies', 'companies_id', '=', 'companies.id')
        ->join('persons as admresp', 'admin_id', '=', 'admresp.id')
        ->join('persons as intresp', 'responsible_id', '=', 'intresp.id')
        ->join('persons as student', 'intern_id', '=', 'student.id')
        ->join('contractstates', 'contractstate_id', '=', 'contractstates.id')
        ->whereIn('contractstate_id', $selectable)
        ->select(
            'internships.id',
            'beginDate',
            'grossSalary',
            'companyName',
            'admresp.firstname as arespfirstname',
            'admresp.lastname as aresplastname',
            'intresp.firstname as irespfirstname',
            'intresp.lastname as iresplastname',
            'student.firstname as studentfirstname',
            "student.id",
            'student.lastname as studentlastname',
            'contractstate_id',
            'stateDescription')
        ->get();

        return $internsiphs;
    }



}
