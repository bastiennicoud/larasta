<?php
// *************************************************

namespace App\Http\Controllers;

use App\EvaluationSection;
use App\Criteria;
use Illuminate\Http\Request;

class EditGridController extends Controller
{
    // index, base route
    public function index()
    {
        return view('editGrid/editGrid');
    }

    //Function to modify criteria
    public function editCriteria($field, $id, $newValue){
        if($criteria = Criteria::find($id)){
            switch($field){
                case 'criteriaName':
                    strlen($newValue) <= 45 ? $criteria->criteriaName = $newValue : $msgerror = "Valeur max: 45";
                break;

                case 'criteriaDetails':
                    strlen($newValue) <= 1000 ? $criteria->criteriaDetails = $newValue : $msgerror = "Valeur max: 1000";
                break;

                case 'maxPoints':
                    $criteria->maxPoints = $newValue;
                break;

                default;
            }
            $criteria->save();
        }
    }
}
