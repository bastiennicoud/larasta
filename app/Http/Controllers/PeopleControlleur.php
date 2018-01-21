<?php
/**
 * Created by PhpStorm.
 * User: Davide.CARBONI
 * Date: 18.12.2017
 * Time: 09:06
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persons;
use CPNVEnvironment\Environment;
use Illuminate\Support\Facades\DB;

class PeopleControlleur extends Controller
{
    // get all peoples and return in the view
    public function index()
    {
        // Get the user right
        $user = Environment::currentUser();

        // Read peoples from DB
        $persons = DB::table('persons')
            ->select('persons.id','firstname','lastname','role','obsolete')
            ->where('obsolete','=', 0)
            ->orderBy('firstname','asc')
            ->get();

        // return all value to view
        return view('listPeople/people')->with(
            [
                'persons' => $persons,
                'user' => $user
            ]
        );
    }

    // get peoples that match the filter and return in the view
    public function category(Request $request)
    {
        // Get post values from the form
        $filtersCategory = $request->input('filterCategory');
        $filterName = $request->input('filterName');
        $filterReset = $request->input('reset');
        $filterObsolete = $request->input('filterObsolete');

        // Prepare the query and read data from DB
        $query = $this->filterQueryPrepare($request);
        $persons = $query->get();

        // Get the user right
        $user = Environment::currentUser();

        // change array filters with null value if reset button has clicked
        if ($filterReset != null)
            $filtersCategory = $filterName = $filterObsolete = null;

        // return all value to view
        /*$view = view("listPeople/AJXpeople",compact('persons'))->render();
        return response()->json(['html'=>$view]);*/
        return view('listPeople/people')->with(
            [
                'persons' => $persons,
                'user' => $user,
                'filterCategory'=> $filtersCategory,
                'filterName'=>$filterName,
                'filterObsolete' =>$filterObsolete
            ]
        );
    }

    // Prepare the query with the selected filters
    private function filterQueryPrepare($filters)
    {
        // Get post values from the form
        $filtersCategory = $filters->input('filterCategory');
        $filterName = $filters->input('filterName');
        $filterObsolete = $filters->input('filterObsolete');
        $filterReset = $filters->input('reset');

        // Prepare the base query
        $query = $persons = DB::table('persons')
            ->select('persons.id', 'firstname', 'lastname', 'role','obsolete')
            ->orderBy('firstname', 'asc');

        // Prepare the query with filters
        if ($filterReset == null)                             // do nothing if reset button has clicked
        {
            if ($filterObsolete == null)
                $query->where('obsolete', '=', 0);
            else
                $query->where('obsolete', '=', 1);

            if ($filtersCategory != null)                     // create filter for category
                $query->whereIn('role', $filtersCategory);

            if ($filterName != null)                         // create filter for FirstName and LastName
            {
                $query->where('persons.firstname', 'like', '%' . $filterName . '%');
                $query->orwhere('persons.lastname', 'like', '%' . $filterName . '%');
            }


        }

        return $query;
    }

    public function info(Request $request, $id)
    {
        // Get the user right
        $user = Environment::currentUser();

        // Read Address from DB
        $person = DB::table('persons')
            ->select('persons.id','firstname','lastname','role','obsolete')
            ->where('persons.id','=',$id)
            ->get()->first();

        // Read Adresse from DB
        $adress = DB::table('persons')
            ->join('locations', 'persons.location_id', '=', 'locations.id')
            ->select('address1','address2','postalCode','city','lat','lng')
            ->where('persons.id','=',$id)
            ->get()->first();

        // Read Contact info from DB
        $contacts = DB::table('contactinfos')
            ->join('contacttypes', 'contacttypes.id', '=', 'contactinfos.contacttypes_id')
            ->select('contactTypeDescription','value')
            ->where('persons_id','=',$id)
            ->get();

        // Read Stages from  DB
        $stages = DB::table('internships')
            ->join('companies','internships.companies_id','=','companies.id')
            ->select('companyName')
            ->where('internships.intern_id','=',$id)
            ->get();

        // return all value to view

        return view('listPeople/peopleEdit')->with(
            [
                'person' => $person,
                'adress' => $adress,
                'contacts' => $contacts,
                'stages' => $stages,
                'user' => $user
            ]
        );
    }

    public function update(Request $request, $id)
    {
        // Get the user right
        $user = Environment::currentUser();

        DB::table('persons')
            ->where('id', $id)
            ->update(['obsolete' => 1]);

        return redirect("/listPeople/$id/info");
    }

}