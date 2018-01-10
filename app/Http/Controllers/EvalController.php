<?php
/**
 * EvalController
 * 
 * Bastien Nicoud
 * v1.0.0
 */


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Visit;
use App\Criteria;
use App\CriteriaValue;
use App\Evaluation;
use App\EvaluationSection;


/**
 * EvalController
 * 
 * Provides the methods to complete, submit and validate the datas indicated by the user in the evaluation grid.
 */
class EvalController extends Controller
{
    /**
     * index
     *
     * Display de evaluation grid section
     * 
     * @return view evalGrid/grid
     */
    public function index()
    {
        return view('evalGrid/home');
    }




    /**
     * newEval
     * 
     * This method register a new evaluation for the connected user (linked to the vist table)
     * 1. get the id of the visit
     * 2. Check if the visit exists
     * 2. Add a record in the evaluations table to create the evaluation
     * 
     * @param Request $request
     */
    public function newEval(Request $request)
    {
        // Reach the id of the vist witch add the evaluation
        $visit = $request->route('visit');

        // Check if this vist really exists
        if (Visit::where('id', '=', $visit)->exists()) {
            // The visit exists
        } else {
            
        }
        //User::where('email', '=', Input::get('email'))->exists()
    }




    /**
     * editCriteriaValue
     * 
     * Save the user evaluation value in the database
     */




    /**
     * getEval
     * 
     * Get the evaluation grid from the database
     *
     * @return view evalGrid/grid
     */
    public function getEval()
    {
        // Here we get all the evaluation grid

        // Return a colection with all the evaluation sections in an array with the criterias of each section
        $temp = EvaluationSection::with('criterias')->get();

        return $temp;
    }
}
