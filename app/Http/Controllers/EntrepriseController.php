<?php

namespace App\Http\Controllers;
use App\Remark;
use CPNVEnvironment\Environment;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\RemarksController;


class EntrepriseController extends Controller
{

    public function index($id, $msg=null){
        $user = Environment::currentUser();

        $company = DB::table('companies')
            ->join('locations', 'location_id', '=', 'locations.id')
            ->join('contracts', 'contracts_id','=', 'contracts.id')
            ->select('companyName','address1','address2','postalCode','city','contractType', 'contracts_id','lat','lng','location_id')
            ->where('companies.id',$id)
            ->get();

        $eType = DB::table('contracts')
            ->select('id', 'contractType')
            ->get();

        $persons = DB::table('persons')
            ->select('firstname', 'lastname', 'id', 'obsolete')
            ->where('company_id','=',$id)
            ->get();

        $contacts = DB::table('contactinfos')
            ->join('persons','persons.id','=','persons_id')
            ->select('contacttypes_id','value','firstname','lastname','persons.id as personId')
            ->where('company_id','=',$id)
            ->get();

        $iships = DB::table('internships')
            ->join('companies', 'companies_id', '=', 'companies.id')
            ->join('persons as admresp', 'admin_id', '=', 'admresp.id')
            ->join('persons as intresp', 'responsible_id', '=', 'intresp.id')
            ->join('persons as student', 'intern_id', '=', 'student.id')
            ->join('contractstates', 'contractstate_id', '=', 'contractstates.id')
            ->join('flocks', 'student.flock_id', '=', 'flocks.id')
            ->join('persons as mc', 'classMaster_id', '=', 'mc.id')
            ->select(
                'internships.id',
                'beginDate',
                'endDate',
                'companyName',
                'admresp.firstname as arespfirstname',
                'admresp.lastname as aresplastname',
                'intresp.firstname as irespfirstname',
                'intresp.lastname as iresplastname',
                'student.firstname as studentfirstname',
                'student.lastname as studentlastname',
                'mc.intranetUserId as mcid',
                'mc.initials as mcini',
                'contractstate_id',
                'stateDescription')
            ->where('companies_id', $id)
            ->get();

        $remarks = DB::table('remarks')
            ->select('id','remarkDate','author','remarkText')
            ->where('remarkType',1)
            ->where('remarkOn_id', $id)
            ->get();


        return view('/entreprises/entreprise')->with(['company' => $company, 'user' => $user, 'persons' => $persons, 'contacts' => $contacts,  'iships'=>$iships, 'remarks'=>$remarks, 'message'=>$msg, 'contracts' => $eType]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return $this
     */
    public function save(Request $request, $id){  // $request data : address1, address2, npa, city, ctype, location_id

        DB::table('companies')
            ->where('id',$id)
            ->update(['contracts_id' => $request->ctype]);

        $actualLocation = DB::table('locations')
            ->select('address1','address2', 'postalCode', 'city')
            ->where('id',$request->location_id)
            ->get();

        if ($request->address1 != $actualLocation[0]->address1 || $actualLocation[0]->address2 != $request->address2 || $actualLocation[0]->postalCode != $request->npa || $actualLocation[0]->city != $request->city)
        {
            $ok = $this->updateLocation($request);
            $error = is_string($ok); //check if an api error occurred

            if ($error == true) { //return error message from google api
                return $this->index($id,$ok);
            }

            if ($ok){ //If no problem, update location with success message
                DB::table('locations')
                    ->where('id', $request->location_id)
                    ->update(['address1' => $request->address1, 'address2' => $request->address2, 'postalCode' => $request->npa, 'city' => $request->city]);
                return $this->index($id,"Adresse retrouvée sur Google Maps, la carte est disponible");
            }
            else //If have a problem, update location with null
            {
                DB::table('locations')
                    ->where('id',$request->location_id)
                    ->update(['lat' => null, 'lng' => null]);
                return $this->index($id,"Adresse pas retrouvée sur Google Maps");
            }
        }
        else
        {
            return $this->index($id, "Modifications enregistrées");
        }
    }

    public function updateLocation($request)
    {
        $ok = false;

        $adress1 = str_replace(" ", "+", $request->address1);
        $url = "https://maps.google.com/maps/api/geocode/json?address=$adress1,$request->npa,Suisse&sensor=false&key=" . $_ENV['API_GOOGLE_MAP'];
        $data = file_get_contents($url);
        $json = json_decode($data, true);
        $error = $this->checkGoogleAPI($data);


        if ($error != null) { //If google api return error
            return $error;
        }

        if (isset($json["results"][0]["address_components"]))
            foreach ($json["results"][0]["address_components"] as $item)
                if ($item["types"][0] == "postal_code")
                    $GNPA = $item["long_name"];

        if (isset($GNPA) && ($request->npa == $GNPA)) // on a trouvé quelquechose sur google
        {
            $lat = $json["results"][0]["geometry"]["location"]["lat"];
            $lng = $json["results"][0]["geometry"]["location"]["lng"];
            DB::table('locations')
                ->where('id', $request->location_id)
                ->update(['lat' => $lat, 'lng' => $lng]);
            $ok = true;
        } else error_log("Update location from googleMaps failed.\nRequest: $url\nResponse: $data");

        return $ok;
    }

    /// Check if we have a problem with request
    /// the most popular message it's daily quota end
    public function checkGoogleAPI($data){
        if(isset($data[count($data)-1]["error_message"])) {
            return $data[count($data)-1]["error_message"];
        }
        return null;
    }

    public function remove($id){
        /*
        DB::table('internships')
            ->where('companies_id', $id)
            ->delete();

        DB::table('locations')
            ->where('id', $id)
            ->delete();

        DB::table('companies')
            ->where('id', $id)
            ->delete();
        */
    }

    public function addRemarks(Request $request)
    {
        $type = 1;
        $on = $request->id;
        $text = $request->remark;
        RemarksController::addRemark($type,$on,$text);
    }
}
