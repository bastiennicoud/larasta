<?php
/**
 * Created by PhpStorm.
 * User: JulienRichoz
 * Date: 08.01.2018
 * Time: 08:45
 * Contact: julien.richoz@cpnv.ch
 *
 * Description: Controller to modify data in the database for the evaluation Grid.
 */


namespace App\Http\Controllers;

use App\EvaluationSection;
use App\Criteria;
use CPNVEnvironment\Environment;
use Illuminate\Http\Request;

class EditGridController extends Controller
{
    // Check permission and show editGrid view with db informations
    public function index()
    {
        // Check if the user is a superuser
        // We grant him access to editGrid if he has access (superuser only, level = 2)
        if (Environment::currentUser()->getLevel() > 1 ) {

            // Return to the view with record of tables Criteria and EvaluationSection
            $dataCriteria = Criteria::all();
            $dataSection = EvaluationSection::all();
            return view('editGrid/editGrid')->with(
                [
                    'criterias' => $dataCriteria,
                    'sections' => $dataSection
                ]
            );

        }
        // If not a superuser, we redirect him to home page with a message status
        else {
            return redirect('/')->with('status', "You don't have the permission to access this page.");
        }
    }



    // -------------------------------------- *** CRITERIA MODIFICATION *** --------------------------------------------

    //ADD a new Criteria
    public function addCriteria(Request $request)
    {
        $newValue = $request->newValue;
        $idSection = $request->idSection;

        //Check value and add new criteria in the table Criteria
        if ($idSection > 0 || $newValue != null) {
            $criteria = new Criteria;
            $criteria->criteriaName = $newValue;
            $criteria->evaluationSection_id = $idSection;
            $criteria->save();
            print_r("yes");
        }
        else {
            print_r("no");
        }

    }


    // EDIT Criteria (Update only)
    /**
     * @param $field
     * @param $id
     * @param $newValue
     */
    public function editCriteria(Request $request)
    {
        $msgerror = null;
        $id = $request->id;
        $field = $request->field;
        $newValue = $request->newValue;

        if ($criteria = Criteria::findOrFail($id)) {

            // Check which field we have to modify in the table Criteria (criteriaName, criteriaDetails, maxPoints)
            switch ($field) {
                case 'criteriaName':
                    strlen($newValue) <= 45 ? $criteria->criteriaName = $newValue : $msgerror = "Maximum characters: 45";
                    break;

                case 'criteriaDetails':
                    strlen($newValue) <= 1000 ? $criteria->criteriaDetails = $newValue : $msgerror = "Maximum characters: 1000";
                    break;

                case 'maxPoints':
                    is_numeric($newValue) || $newValue == "" ? $criteria->maxPoints = $newValue : $msgerror = "Value must be an num";
                    break;

                default;
            }
            // If the value is correct, we save it in the database
            if ($msgerror == null) {
                $criteria->update();
                print_r("yes");
            } // If value incorrect -> no saving
            else {
                print_r("no");
            }
        }
    }


    //DELETE a Criteria
    public function removeCriteria(Request $request) //idCriteria
    {
        $id = $request->id;

        if ($criteria = Criteria::findOrFail($id)) {
            $criteria->delete($id);
            print_r("yes");
        }
        else {
            print_r("no");
        }
    }



    // --------------------------------- *** EVALUATION SECTION MODIFICATION *** ---------------------------------------

    // ADD a new EvaluationSection
    public function addSection(Request $request)
    {
        $sectionType = $request->sectionType;
        $sectionName = $request->newSectionName;
        $hasGrade = null;

        // !!! Actually only sectionType 1 has grade. To modify if we add new sectionType. !!!
        if ($sectionType == 1) {
            $hasGrade = 1;
        }
        else if ($sectionType == 2 || $sectionType == 3) {
            $hasGrade = 0;
        }

        // Create new record in the table EvaluationSection
        if ($sectionType > 0 && $sectionType < 4 && $sectionName != null && $hasGrade >= 0 && $hasGrade <= 1) {
            $section = new EvaluationSection;
            $section->sectionName = $sectionName;
            $section->sectionType = $sectionType;
            $section->hasGrade = $hasGrade;
            $section->save();
            return redirect('/editGrid');
        }
    }


    // MODIFY EvaluationSection(update only)
    public function editSection(Request $request)
    {
        $msgerror = null;
        $id = $request->id;
        $field = $request->field;
        $newValue = $request->newValue;
        if ($section = EvaluationSection::findOrFail($id)) {

            // Check which field we have to modify in the table EvaluationSection (sectionName, hasGrade, sectionType)
            switch ($field) {
                case 'sectionName':
                    strlen($newValue) <= 45 ? $section->sectionName = $newValue : $msgerror = "Maximum characters: 45";
                    break;

                case 'hasGrade':
                    is_int($newValue) ? $section->hasGrade = $newValue : $msgerror = "Value must be an int";
                    break;

                case 'sectionType':
                    ($newValue > 0 && $newValue < 4) ? $section->sectionType = $newValue : $msgerror = "Value must be beetween 1 and 3";
                    break;

                default;
            }
            //If the value is correct, we save it in the database
            if ($msgerror == null) {
                $section->update(); //Update will modify the record // Save will insert a new record in the DB
                print_r("yes");
                //return redirect()->with('status', 'Criteria modified');
            }
            //if value incorrect -> no saving
            else {
                print_r("no");
            }
        }
    }


    // DELETE an evaluationSection
    public function removeSection(Request $request)
    {
        $id = $request->id;

        if ($section = EvaluationSection::findOrFail($id)) {
            Criteria::where('evaluationSection_id', '=', $id)->delete();    //First Delete Foreign Key in Criteria Table
            $section->delete();                                             //Then Delete Full section($id)
            print_r("yes");
        }
        else {
            print_r("no");
        }
    }
}



