<?php
//------------------------------------------------------------
// Nicolas Henry
// SI-T1a
// ReconStagesController.php
//------------------------------------------------------------


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Params;
use Faker\Provider\DateTime;

class ReconStagesController extends Controller
{
    // index, base route
    public function index()
    {
        $internships = $this->getInternships();
        return view('reconstages/reconstages')->with(
            [
                "internships" => $internships
            ]
        );
    }

    public function displayStages()
    {
        return view('reconstages/reconmade');
    }


    //get value from db
    public function getInternships(){
        //get value from table Params to put them in SQL request
        foreach(Params::all() as $param)
        {
            if($param->paramName == "reconductible")
            {
                $selectable[] = $param->paramValueInt;
            }
        }

        $internships = DB::table('internships')
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

        return $internships;
    }

    //Send value to reconMade page with function displayRecon()
    public function reconStages(Request $request){
        $keys = $request->all();
        $ids = [];

        foreach ($keys as $key => $value) {

            if ($key != '_token') {
                array_push($ids, $value);
            }
        }

        $internships = $this->getInternships();
        $new = $this->displayRecon($ids, $internships);


        
        return view('reconstages/reconstages')->with(
            [
                "internships" => $new
            ]
        );

    }


    //get values from input in an array
    public function displayRecon($ids, $internships){

        $newInternships = [];
        foreach ($internships as $internship) {
            foreach($ids as $id){
                if($internship->id==$id){
                    array_push($newInternships, $internship);
                }
            }
        }
        

        $insert = [];
        foreach ($ids as $id) {
            $insert[] = [
                'companies_id'              => '112',
                'beginDate'                 => '2018-02-01 00:00:00',
                'endDate'                   => '2018-09-01 00:00:00',
                'responsible_id'            => '191',
                'admin_id'                  => '79',
                'intern_id'                 => $id,
                'contractstate_id'          => '2',
                'previous_id'               => '390',
                'internshipDescription'     => 'tutu',
                'grossSalary'               => '7000',
                'contractGenerated'         => null,
            ];
        }

        DB::table('internships')->insert($insert);
        
        return $newInternships;

        
    }

    //a suivre...
    public function insertRecon(){

    }


}
