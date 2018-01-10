<?php
/**
 * EvalController
 * 
 * Bastien Nicoud
 * v1.0.0
 */


namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
     * Returns the Evaluation grid complete wiew.
     * 
     * @return view evalGrid/grid
     */
    public function index()
    {
        $evalGrid = $this->getEval();

        return view('evalGrid/grid')->with('evalGrid', $evalGrid);
    }

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
