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
    public function newEval(Request $request, int $visit = 0)
    {

        // Check if this vist really exists (prevent pest users)
        if (!Visit::where('id', '=', $visit)->exists()) {

            // The visit not exist
            // Return the visit list with an error message
            return redirect('visits')->with('status', 'ID de la visite non valide ?');

        } else {

            // The visit exists
            // Check if the user is authored
            if (Environment::currentUser()->getLevel() < 1) {

                // Student, have no acces to this function
                // Return the visit list with an error message
                return redirect('visits')->with('status', "Vous ne pouver pas créér d'evaluation");

            } else {

                // The user is authored
                // Create the new evaluation
                $evaluation = Evaluation::create(['visit_id' => $visit, 'editable' => 1]);

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
     * @param int|bool $id
     * 
     * @return view
     */
    public function editEval(Request $request, string $mode = 'readonly', $gridID = null)
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
                return redirect('visits')->with('status', "Veuillez specifier une evaluation pour l'editer");
            }
        } else {
            // If the id of the grid is passed in the uri, we store it in the session for efficient work
            $request->session()->put('activeEditedGrid', $gridID);
        }

        // check if the grid exists and is editable
        if ($evaluation = Evaluation::with('visit.internship')->find($gridID)){
            // The grid exists
            // If the user want to edit the grid
            if ($mode == 'edit') {
                // Check if the grid is editable
                if ($evaluation->editable == 0) {
                    // if not we redirect to the readonly version of the page
                    return redirect('evalgrid/grid/readonly')->with('status', 'Vous ne pouvez plus editer cette grille, vous etes passé en lecture seule.');
                }
            }
        } else {
            // The evaluation dont exists in the database
            // delete the id in the session and redirect to the visits
            $request->session()->forget('activeEditedGrid');
            return redirect('visits')->with('status', "Cette evaluation n'existe pas !");
        }

        // check the user authorisations
        // Only the internship supervisor and the concerned student can acess the evaluation
        // check the forein keys to verifiy the user

        // If the user is a student
        if (Environment::currentUser()->getLevel() == 0) {
            // Check if this eval belongs to this user
            if ($evaluation->visit->internship->intern_id != Environment::currentUser()->getId()) {
                // This eval not belongs to this student (he can wiew id and edit the student comment fields)
                $request->session()->forget('activeEditedGrid');
                return redirect('visits')->with('status', "Cette evaluation ne vous apartient pas, vous ne pouvez donc pas la consulter.");
            }
        } elseif (Environment::currentUser()->getLevel() == 1) {
            // Check if this student is able to wiew and edit the eval of this student
            if ($evaluation->visit->internship->responsible_id != Environment::currentUser()->getId()) {
                // This teacher don have acces to this evaluation
                $request->session()->forget('activeEditedGrid');
                return redirect('visits')->with('status', "Vous ne pouvez pas accéder a cette evaluation.");
            }
        }

        // The user is authored and the grid exists
        // We call the grid generator
        $evaluationGrid = $this->generateEvaluation($gridID);

        return view('evalGrid/editGrid')->with(['gridID' => $gridID, 'evalGrid' => $evaluationGrid]);
    }




    /**
     * generateEvaluation
     * 
     * This method generates the evaluation with the datas stored in the DB
     * 
     * @param int $gridID the id of the evaluation grid to generates
     * 
     * @return array This array represents all the grid, it is designed to work with the editGrid wiew
     */
    public function generateEvaluation(int $gridID)
    {
        
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
     *          1 = Not started -> editable true, criteriaValues empty
     *          2 = In progress -> editable true
     *          3 = Done editable a false
     */
    public static function getEvalState(int $visitid)
    {
        return rand(1,3); // XCL testing
    }

}
