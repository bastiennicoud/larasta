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
            'stateDescription',
            'companies_id',
            'responsible_id',
            'admin_id',
            'previous_id',
            'internshipDescription')
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

        $beginDate = null;
        $endDate = null;
        $salary = 0;
        $paramBeginDate[] = $this->getParamByName('intership1Start')->paramValueDate;
        $paramBeginDate[] = $this->getParamByName('intership2Start')->paramValueDate;
        $paramEndDate[] = $this->getParamByName('internship1End')->paramValueDate;
        $paramEndDate[] = $this->getParamByName('internship2End')->paramValueDate;
        $newInternships = [];
        foreach ($internships as $internship) {
            foreach($ids as $id){
                if($internship->id==$id){
                    switch (date('m',strtotime($internship->beginDate))){
                        // february
                        case date('m',strtotime($paramBeginDate[0])):
                            $beginDate =  date('Y',strtotime($internship->beginDate)) . '-' . date('m-d',strtotime($paramBeginDate[1]));
                            $endDate = date('Y',strtotime($beginDate)) + 1 . '-' . date('m-d',strtotime($paramEndDate[1]));
                        break;

                        // September
                        case date('m',strtotime($paramBeginDate[1])):
                            $beginDate =  date('Y',strtotime($internship->beginDate)) + 1 . '-' . date('m-d',strtotime($paramBeginDate[0]));
                            $endDate = date('Y',strtotime($beginDate)) . '-' . date('m-d',strtotime($paramEndDate[0]));
                        break;

                        default:
                            // do if the internship begin date is different of the 2 other case
                    }
                    // Salary
                    if($internship->companies_id == 26 || $internship->companies_id == 35 )
                    {
                        $salary = $internship->grossSalary + 400;
                    }
                    else
                    {
                        $salary = $internship->grossSalary;
                    }
                    // !!!!!!!!!!!! Test !!!!!!!!!!!!!!
                    array_push($newInternships, $internship);
                    // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
                    $insert[] = [
                        'companies_id'              => $internship->companies_id,
                        'beginDate'                 => $beginDate,
                        'endDate'                   => $endDate,
                        'responsible_id'            => $internship->responsible_id,
                        'admin_id'                  => $internship->admin_id,
                        'intern_id'                 => $id,
                        'contractstate_id'          => '2',
                        'previous_id'               => $internship->previous_id,
                        'internshipDescription'     => $internship->internshipDescription,
                        'grossSalary'               => $salary,
                        'contractGenerated'         => null,
                    ];
                    DB::table('internships')->insert($insert);
                }
            }
        }
        
        return $newInternships;

        
    }
    private function getParamByName($name)
    {
        $param = Params::where('paramName', $name)
        ->first();
        return $param;
    }


}
