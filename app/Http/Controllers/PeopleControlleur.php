<?php
/**
 * Created by PhpStorm.
 * User: Davide.CARBONI
 * Date: 18.12.2017
 * Time: 09:06
 *
 * !!!!! IMPORTANT !!!!
 * ONLY FOR TEACHER ROLE
 * If you want have all contacts informations for teacher -> do nothing
 * If you want have nothing information for teacher so go to the STEP by STEP procedure
 * STEP by STEP: folow the step procedure starting in the Step 1 in the update function
 * After finished go to PeopleEdit blade and follow the same procedure
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persons;
use CPNVEnvironment\Environment;
use Illuminate\Support\Facades\DB;

class PeopleControlleur extends Controller
{
    /**
    /* Get all peoples and return in the view
     * Passing first filter for teacher (0->student, 1->teacher, 2->company)
     * Passing first filter for Obsolete (0->desactivate, 1->activate)
     */
    public function index()
    {
        // Get the user right
        $user = Environment::currentUser();

        $persons = Persons::where('obsolete', 0)
            ->orderBy('firstname', 'asc')
            ->get();
        // return all value to view
        return view('listPeople/people')->with(
            [
                'persons' => $persons,
                'user' => $user,
                'filterCategory'=> ["0","1","2"],
                'filterObsolete' => null
            ]
        );
    }

    /**
     * Get peoples that match the filter and return in the view
     *
     * @param $request
     */
    public function category(Request $request)
    {
        //$request->flash();
        // Get post values from the form
        $filtersCategory = $request->input('filterCategory');
        $filterName = $request->input('filterName');
        $filterObsolete = $request->input('filterObsolete');

        // Verify if all checkboks are not selected
        if ($filtersCategory == null) $filtersCategory = ["-1"];

        // Get the user right
        $user = Environment::currentUser();

        // Apply scope form Model Persons and get data
        $persons = Persons::obsolete($filterObsolete)->category($filtersCategory)->orderBy('firstname', 'asc')->Name($filterName)->get();

        // return all value to view with the value of filters
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

    /**
     * Get all info for people
     *
     * @param $id
     */
    public function info($id)
    {
        // Get the user right
        $user = Environment::currentUser();

        // Read Person from DB
        $person = DB::table('persons')
            ->select('persons.id','firstname','lastname','role','obsolete','location_id')
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

        // Read stages info from DB
        $iship = DB::table('internships')
            ->join('companies', 'companies_id', '=', 'companies.id')
            ->join('persons as admresp', 'admin_id', '=', 'admresp.id')
            ->join('persons as intresp', 'responsible_id', '=', 'intresp.id')
            ->join('persons as student', 'intern_id', '=', 'student.id')
            ->join('contractstates', 'contractstate_id', '=', 'contractstates.id')
            ->join('flocks', 'student.flock_id', '=', 'flocks.id')
            ->join('persons as mc', 'flocks.classMaster_id', '=', 'mc.id')
            ->select(
                'internships.id',
                'beginDate',
                'endDate',
                'companyName',
                'grossSalary',
                'mc.initials',
                'previous_id',
                'internshipDescription',
                'admresp.firstname as arespfirstname',
                'admresp.lastname as aresplastname',
                'intresp.firstname as irespfirstname',
                'intresp.lastname as iresplastname',
                'student.firstname as studentfirstname',
                'student.lastname as studentlastname',
                'contractstate_id',
                'contractGenerated',
                'stateDescription')
            ->where('internships.intern_id','=', $id)
            ->get();

        // return all values in view
        return view('listPeople/peopleEdit')->with(
            [
                'person' => $person,
                'adress' => $adress,
                'contacts' => $contacts,
                'iships' => $iship,
                'user' => $user
            ]
        );
    }

    /**
     * Update all value for the selected people
     *
     * @param $request
     * @param $id
     */
    public function update(Request $request, $id)
    {
        // Extract all the values int he Request
        $Role = $request->input('role');
        $Adress1 = $request->input('adress1');
        $Adress2 = $request->input('adress2');
        $PostalCode = $request->input('postalCode');
        $City = $request->input('city');
        $LocationID = $request->input('locationID');
        $Mails = $request->input('mail');
        $FixePhones = $request->input('phoneFixe');
        $MobilePhones = $request->input('phoneMobile');

        ///////////////////////////////////////
        /// Obsolete
        ///////////////////////////////////////

        // Create the value to Obsolote to insert in the DB (0,1)
        $Obsolete = ($request->input('obsolete') ==  null) ? 0 : 1;

        ///////////////////////////////////////
        /// Adress
        ///////////////////////////////////////

        // Desactive or Activate the person in the DB
        DB::table('persons')
            ->where('id', $id)
            ->update(['obsolete' => $Obsolete]);

        // Change adress values for all people except if the role is teacher
        if ($Role != 1) {
            // Create de adress with all value to goole maps
            $address = $Adress1 . "," . $PostalCode . "," . $City;
            $address = str_replace(" ", "+", $address);

            // Google Maps get long and lat values
            // Get JSON results from this request
            $geo = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false');
            $geo = json_decode($geo, true); // Convert the JSON to an array

            // Verify if the answer from google maps is OK
            if (isset($geo['status']) && ($geo['status'] == 'OK')) {
                $lat = $geo['results'][0]['geometry']['location']['lat']; // Latitude
                $long = $geo['results'][0]['geometry']['location']['lng']; // Longitude
            } else
                // Put Null value if long e lat is not available
                $lat = $long = NULL;

            // Modifify data location for the selectes person
            DB::table('locations')
                ->where('id', $LocationID)
                ->update([
                    'address1' => $Adress1,
                    'address2' => $Adress2,
                    'postalCode' => $PostalCode,
                    'city' => $City,
                    'lat' => $lat,
                    'lng' => $long
                ]);

        // Step 1
        // Delete this line and go to Step 2
        }

        ///////////////////////////////////////
        /// Contacts
        ///////////////////////////////////////

        // delete old contact info in the DB
        DB::table('contactinfos')
            ->where('persons_id', '=', $id)
            ->delete();


        // write all new mails in the DB
        foreach ($Mails as $mail)
        {
            if ($mail != null)
                DB::table('contactinfos')->insert(
                    ['value' => $mail, 'contacttypes_id' => 1, 'persons_id' => $id]
                );

        }

        // write all new fixe phone numbers in the DB
        foreach ($FixePhones as $phoneFixe)
        {
            if ($phoneFixe != null)
                DB::table('contactinfos')->insert(
                    ['value' => $phoneFixe, 'contacttypes_id' => 2, 'persons_id' => $id]
                );

        }

        // write all new phone mobile numbers in the DB
        foreach ($MobilePhones as $mobilePhone)
        {
            if ($mobilePhone != null)
                DB::table('contactinfos')->insert(
                    ['value' => $mobilePhone, 'contacttypes_id' => 3, 'persons_id' => $id]
                );
        }

        // Step 2
        // Uncomment this line and you are finish
        // Verify the PeopleEdit blade and folow the same procedure
        // }

        return $this->info($id);
    }

}