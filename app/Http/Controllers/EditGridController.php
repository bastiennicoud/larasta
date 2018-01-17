<?php
/**
 * Created by PhpStorm.
 * User: JulienRichoz
 * Date: 08.01.2018
 * Time: 08:45
 */
namespace App\Http\Controllers;

use App\EvaluationSection;
use App\Criteria;
use CPNVEnvironment\Environment;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Null_;


class EditGridController extends Controller
{
    // index, base route
    public function index()
    {
        // Check if the user is a superuser
        //We grant him access to editGrid if he has access
        if (Environment::currentUser()->getLevel() < 5){ // ! ! ! Let the access for developpment, but need to put it at >1

            //Get the record from the DB and return to the view
            $dataCriteria = Criteria::all();
            $dataSection = EvaluationSection::all();
            return view('editGrid/editGrid')->with(
                [
                    'criterias' => $dataCriteria,
                    'sections' => $dataSection
                ]
            );

        }

        //If not a superuser, we redirect him to home page
        else{
            return redirect('/')->with('status', "You don't have the permission to access this function.");
        }
    }

    //Function to modify criteria
    /**
     * @param $field
     * @param $id
     * @param $newValue
     */
    public function editCriteria($field, $id, $newValue){
        if($criteria = Criteria::findOrFail($id)){
            $msgerror = null;
            switch($field){
                case 'criteriaName':
                    strlen($newValue) <= 45 ? $criteria->criteriaName = $newValue : $msgerror = "Maximum characters: 45";
                break;

                case 'criteriaDetails':
                    strlen($newValue) <= 1000 ? $criteria->criteriaDetails = $newValue : $msgerror = "Maximum characters: 1000";
                break;

                case 'maxPoints':
                    is_int($newValue) ? $criteria->maxPoints = $newValue : $msgerror = "Value must be an int";
                break;

                default;
            }
            //If the value is correct, we save it in the database
            if($msgerror == null){
                $criteria->update(); //Update will modify the record // Save will insert a new record in the DB
                return redirect()->back()->with('message', 'Criteria modified');
            }
            //We redirect the superuser to his last previous location
            else{
                return back()->withInput()->with('status', $msgerror);
            }
        }
    }


    //Function to modify section (EvaluationSection)
    public function editSection($field, $id, $newValue){
        if($section = EvaluationSection::findOrFail($id)){
            $msgerror = null;
            switch($field){
                case 'sectionName':
                    strlen($newValue) <= 45 ? $section->sectionName = $newValue : $msgerror = "Maximum characters: 45";
                break;

                case 'hasGrade':
                    is_int($newValue) ? $section->hasGrade = $newValue : $msgerror = "Value must be an int";
                break;

                case 'sectionType':
                    ($newValue>0 && $newValue<4) ? $section->sectionType = $newValue : $msgerror = "Value must be beetween 1 and 3";
                break;

                default;
            }
            //If the value is correct, we save it in the database
            if($msgerror == null){
                $section->update();
                return redirect()->back()->with('message', 'section modified');
            }
            //We redirect the superuser to his last previous location
            else{
                return back()->withInput()->with('status', $msgerror);
            }
        }
    }

    //Function to add a section
    public function addSection(){
        //TO DEVELOP
    }

    //Function to remove a section
    public function removeSection(){
        //TO DEVELOP
    }

    //Function to add a row in a section
    public function addCriteria(){
        //TO DEVELOP
    }

    //Function to remove a row in a section
    public function removeCriteria(){
        //TO DEVELOP
    }

}
