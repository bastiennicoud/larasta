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

    //return to view reconmade
    //public function displayStages()
    //{
    //    return view('reconstages/reconmade');
    //}


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
        
        //requete de récuperation des données dans la base de donnée
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
            'endDate',
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
            'internshipDescription',
            'contracts_id')
        ->get();

        return $internships;
    }

    //Send value to reconMade page with function displayRecon()
    public function reconStages(Request $request){


        $keys = $request->all();
        $ids = [];

        foreach ($keys as $key => $value) {
            if ($key != '_token') {
                // Push id user in ids array
                array_push($ids, $value);
            }
        }

        
        $internships = $this->getInternships();
        $new = $this->displayRecon($ids, $internships);

        //return data to the view reconmade
        return view('reconstages/reconmade')->with(
            [
                "internships" => $new
            ]
        );

    }


    //get values from input in an array
    public function displayRecon($ids, $internships){
        //define table
        $beginDate = null;
        $endDate = null;
        $salary = 0;
        //get date from the table param in the function getParamByName()
        $paramBeginDate[] = $this->getParamByName('internship1Start')->paramValueDate;
        $paramBeginDate[] = $this->getParamByName('internship2Start')->paramValueDate;
        $paramEndDate[] = $this->getParamByName('internship1End')->paramValueDate;
        $paramEndDate[] = $this->getParamByName('internship2End')->paramValueDate;
        $newInternships = [];

        //Get all internships
        foreach ($internships as $internship) {
            //Get id of internships
            foreach($ids as $id){
                //check if the ID are correct
                if($internship->id==$id){

                    // Switch for stage begin date
                    switch (date('m',strtotime($internship->beginDate))){
                        // february
                        case date('m',strtotime($paramBeginDate[0])):
                        // Construct the date (begin, end) for the reconductible internship
                            $beginDate =  date('Y',strtotime($internship->beginDate)) . '-' . date('m-d',strtotime($paramBeginDate[1]));
                            $endDate = date('Y',strtotime($beginDate)) + 1 . '-' . date('m-d',strtotime($paramEndDate[1]));
                        break;

                        // September
                        case date('m',strtotime($paramBeginDate[1])):
                        // Construct the date (begin, end) for the reconductible internship
                            $beginDate =  date('Y',strtotime($internship->beginDate)) + 1 . '-' . date('m-d',strtotime($paramBeginDate[0]));
                            $endDate = date('Y',strtotime($beginDate)) . '-' . date('m-d',strtotime($paramEndDate[0]));
                        break;

                        default:
                        // do if the internship begin date is different of the 2 other case
                        $monthDiff1 = date('m',strtotime($paramBeginDate[0]))-date('m',strtotime($internship->endDate));  
                        $monthDiff2 = date('m',strtotime($paramBeginDate[1]))-date('m',strtotime($internship->endDate));
                        //check the value of the date
                        if($monthDiff1 < 0)
                        {
                            $monthDiff1 += 12;
                        }
                        if($monthDiff2 < 0)
                        {
                            $monthDiff2 += 12;
                        }
                        if($monthDiff1 < $monthDiff2)
                        {
                            $beginDate =  date('Y',strtotime($internship->beginDate)) + 1 . '-' . date('m-d',strtotime($paramBeginDate[0]));
                            $endDate = date('Y',strtotime($beginDate)) . '-' . date('m-d',strtotime($paramEndDate[0]));
                        }
                        else
                        {
                            $beginDate =  date('Y',strtotime($internship->beginDate)) + 1 . '-' . date('m-d',strtotime($paramBeginDate[1]));
                            $endDate = date('Y',strtotime($beginDate)) + 1 . '-' . date('m-d',strtotime($paramEndDate[1]));
                        }
                    }

                    // Salary
                    // Test if internship is from etat de vaud
                    
                    $monthBeginDate = date('m',strtotime($internship->beginDate));
                    if($internship->contracts_id == 4 && $monthBeginDate == date('m',strtotime($paramBeginDate[0])) )
                    {
                        // Add upgrade salary for trainee from Etat de Vaud
                        $salary = $this->getParamByName('internship2Salary')->paramValueInt;
                    }
                    elseif($internship->contracts_id == 4 && $monthBeginDate == date('m',strtotime($paramBeginDate[1])))
                    {
                        $salary = $this->getParamByName('internship1Salary')->paramValueInt;
                    }
                    else
                    {
                        // Keep the previous salary
                        $salary = $internship->grossSalary;
                    }
                    // display value on reconmade.blade
                    array_push($newInternships, $internship);

                    // Insert in dataBase
                    $insert = [
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

    //get params by name and show the first
    private function getParamByName($name)
    {
        $param = Params::where('paramName', $name)
        ->first();
        return $param;
    }


}
