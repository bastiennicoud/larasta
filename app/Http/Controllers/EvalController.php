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
     * index()
     *
     * Returns the Evaluation grid complete wiew.
     * 
     * @return view evalGrid/grid
     */
    public function index()
    {
        $this->getEval();

        return view('evalGrid/grid');
    }

    /**
     * getEval
     *
     * @return view evalGrid/grid
     */
    public function getEval()
    {
        // Here we get all the evaluation form -> after we process it

        $temp = EvaluationSection::find(1)->criterias();

        dd($temp);
    }
}
