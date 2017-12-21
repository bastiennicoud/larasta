<?php
/**
 * EvalController
 * 
 * Bastien Nicoud
 * v1.0.0
 */


namespace App\Http\Controllers;

use Illuminate\Http\Request;


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
        return view('evalGrid/grid');
    }
}
