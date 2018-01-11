<?php
/**
 * EvalController
 * 
 * Bastien Nicoud
 * v1.0.0
 */


namespace App\Http\Controllers;

use Illuminate\Http\Request;

use CPNVEnvironment\Environment;

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
     * Display de evaluation grid section home (just for dev)
     * 
     * @return view evalGrid/grid
     */
    public function index()
    {
        // For dev, we display the evaluations of the visit 30
        $eval = Evaluation::where('visit_id', '=', 30)->get();

        return view('evalGrid/home')->with(['evaluations' => $eval]);
    }




    /**
     * newEval
     * 
     * This method register a new evaluation for the connected user (linked to the vist table)
     * 1. get the id of the visit
     * 2. Check if the visit exists
     * 3. Check if the user is authored
     * 2. Add a record in the evaluations table to create the evaluation and redirect the user to his new evaluation grid
     * 
     * @param Request $request
     * @param int $visit The id of the visit to add the evaluation
     * 
     * @return redirect
     */
    public function newEval(Request $request, $visit = 0)
    {

        // Check if this vist really exists (prevent pest users)
        if (!Visit::where('id', '=', $visit)->exists()) {

            // The visit not exist
            // Return the visit list with an error message
            return redirect('visits')->with('status', 'ID de la visite non valide ?');
            //return view('visits/visits')->with(['message' => 'ID de la visite non valide ?']);

        } else {

            // The visit exists
            // Check if the user is authored
            if (Environment::currentUser()->getLevel() < 1) {

                // Student, have no acces to this function
                // Return the visit list with an error message
                return redirect('visits')->with('status', "Vous n'avez pas acces a cette fonction.");
                //return view('visits/visits')->with(['message' => "Vous n'avez pas acces a cette fonction."]);

            } else {

                // The user is authored
                // Create the new evaluation
                $evaluation = new Evaluation;
                $evaluation->visit_id = $visit;
                $evaluation->editable = 1;
                // Save it
                $evaluation->save();

                // Store in the session the active edited grid (avoid to pass the id in the url)
                $request->session()->put('activeEditedGrid', $evaluation->id);
                // Redirect the user on the edit page of this new grid
                return redirect('evalgrid/grid/edit')->with('status', "Grille d'evaluation correctement créée !");

            }
        }
    }




    /**
     * editEval
     * 
     * Return to the user the evaluation grid to be edit
     * 
     * 1. Check if the grid exists
     * 2. Check if user authored
     * 3. Get all the grid and his parameters
     * 4. return the view (edit or readonly)
     * 
     * @param Request $request
     * @param string $mode (accepts : readonly | edit)
     * @param int $id
     * 
     * @return view
     */
    public function editEval(Request $request, $mode = 'readonly', $gridID = null)
    {

        // To edit a grid, is possible pass his id in request parameters or in session key
        // Here we check the parameter and the session
        if ($gridID == null) {
            // the id is not specified in the request -> we check in the session
            if($request->session()->exists('activeEditedGrid')) {
                // the id is defined in the session, we get it
                $gridID = $request->session()->get('activeEditedGrid');
            } else {
                // we have no id in session or in url params
                return redirect('visits')->with('status', "Cette grille d'évaluation n'existe pas");
            }
        }

        return view('evalGrid/editGrid')->with(['gridID' => $gridID]);
    }




    /**
     * editCriteriaValue
     * 
     * Save the user evaluation value in the database
     */

    /**
     * getEvalState
     *
     * Returns the evaluation state of a given visit
     *
     * @param $visitid The id of the visit
     * @return int Where we are in terms of evaluation regarding this visit.
     *      Values:
     *          1 = Not started
     *          2 = In progress
     *          3 = Done
     */
    public static function getEvalState($visitid)
    {
        return rand(1,3); // XCL testing
    }

}
