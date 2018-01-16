<?php
/**
 * EvalController
 * 
 * Bastien Nicoud
 * v1.0.0
 */


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreEvalGrid;

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

                // Create all the criteria values for this eval
                $criterias = Criteria::all();
                foreach ($criterias as $criteria) {
                    $criteria->criteriaValue()->create([
                        'evaluation_id' => $evaluation->id
                    ]);
                }

                // Redirect the user on the edit page of this new grid
                return redirect("evalgrid/grid/edit/$evaluation->id")->with('status', "Grille d'evaluation correctement créée !");

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
     * @param int|null $id
     * 
     * @return view
     */
    public function editEval(Request $request, string $mode = 'readonly', $gridID = null)
    {

        // To edit a grid, is possible pass his id in request parameters or in session key
        // Here we check the parameter and the session
        if ($gridID == null) {
            // we have no id in session or in url params
            return redirect('visits')->with('status', "Veuillez specifier une evaluation pour l'editer");
        }

        // check if the grid exists and is editable
        if ($evaluation = Evaluation::with('visit.internship.companie')->find($gridID)){
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
            return redirect('visits')->with('status', "Cette evaluation n'existe pas !");
        }

        //dd($evaluation->visit->internship->companie->companyName);

        // check the user authorisations
        // Only the internship supervisor and the concerned student can acess the evaluation
        // check the forein keys to verifiy the user

        // If the user is a student
        if (Environment::currentUser()->getLevel() == 0) {
            // Check if this eval belongs to this user
            if ($evaluation->visit->internship->intern_id != Environment::currentUser()->getId()) {
                // This eval not belongs to this student (he can wiew id and edit the student comment fields)
                return redirect('visits')->with('status', "Cette evaluation ne vous apartient pas, vous ne pouvez donc pas la consulter.");
            }
        }

        // The user is authored and the grid exists
        // We call the grid generator
        $evaluationGrid = $this->generateEvaluation($gridID);

        /**
         * Return the wiew with all the evaluation
         * 
         * @param int $gridID the id of the edited grid
         * @param Evaluation $evaluation the Model with is context
         * @param EvaluationSection $evaluationGrid the model with the sections, all criterias and her values
         * @param strin $mode The type of display edit or readonly
         * @param int $level The level of the connected user
         */
        return view('evalGrid/editGrid')->with([
            'gridID' => $gridID,
            'evaluationContext' => $evaluation,
            'evalGrid' => $evaluationGrid,
            'mode' => $mode,
            'level' => Environment::currentUser()->getLevel()
        ]);
    }




    /**
     * generateEvaluation
     * 
     * This method generates the evaluation with the datas stored in the DB
     * 
     * @param int $gridID the id of the evaluation grid to generates
     * 
     * @return EvaluationSection This collection represents all the grid, it is designed to work with the editGrid wiew
     */
    public function generateEvaluation(int $gridID)
    {
        // get all the fields in the criterias and ordred it by sections
        return EvaluationSection::with(['criterias.criteriaValue' => function($query) use ($gridID) {
            $query->where('evaluation_id', '=', $gridID);
        }])->get();
    }




    /**
     * saveNewGridDatas
     * 
     * Save the user evaluation value in the database
     * 
     * @param App\Http\Requests\StoreEvalGrid $request This specific request validates the input fields and check the authorisation
     * @param int|null $gridID
     */
    public function saveNewGridDatas(StoreEvalGrid $request, $gridID = null)
    {
        // Here we check if the specified grid exists
        if ($gridID == null) {
            // we have no id
            return redirect('visits')->with('status', "Veuillez specifier une evaluation pour l'editer");
        }

        // Save the new grid datas in the DB
        if ($request->submit == 'save') {

            $criteriasValues = CriteriaValue::where('evaluation_id', '=', $gridID);
            foreach ($request->only() as $key => $value) {
                # code...
            }

        } elseif ($request->submit == 'checkout') {
            dd('checkout');
        } else {
            // L'action n'est pas reconnue
        }

        //dd($request->all());
    }




    /**
     * getEvalState
     *
     * Returns the evaluation state of a given visit
     *
     * @param $visitid The id of the visit
     * @return int Where we are in terms of evaluation regarding this visit.
     *      Values:
     *          1 = Not started -> No evaluation
     *          2 = In progress -> editable true
     *          3 = Done editable a false
     */
    public static function getEvalState(int $visitid)
    {
        return rand(1,3); // XCL testing
    }

}
