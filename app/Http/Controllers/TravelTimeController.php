<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;




class TravelTimeController extends Controller
{
    private $message; // a message to display - if defined - in views

    public function index($result=null, $error=false)
    {
        $companies = TravelTimeController::getCompanies();
        $persons = TravelTimeController::getPersons(13);


        $url = TravelTimeController::calculate($companies, $persons);
        echo $url;
        return view('traveltime/traveltime')->with(
            [
                "persons" => $persons,
                "companies" => $companies,
                "result" => $result,
                "error" => $error
            ]
        );
    }


    public function calculate($companies, $persons){
        $origins = null;

        $iteration = 0;
        $res=count($companies)/25;
        $it=null;
        if(is_float($res)){$it = intval($res)+1;}
        else{$it=$res;}

        $destinations = array_fill(0, $it, NULL);

        for($j=0 ; $j<$it-1 ; $j++){
            for($i=$iteration*25 ; $i<$iteration*25+24 ; $i++){
                $destinations[$iteration] .= $companies[$i]->lat.",".$companies[$i]->lng."|";
            }
            $iteration++;
        }

        foreach($persons as $person){
            $origins .= $person->lat.",".$person->lng."|";
        }

        $url="https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$origins."&destinations=".$destinations[0]."&mode=transit&key=".$_ENV['API_GOOGLE_MAP'];
        return $url;

        $json = file_get_contents($url);
        $travel = json_decode($json, true);
        try {
            $duration = $travel["rows"][0]["elements"][0]["duration"]["text"];
            return $this->index($duration, false);
        }
        catch (\Exception $e) {
            return $this->index($e, true);
        }


    }

    public function getCompanies(){
        $companies = DB::table('companies')
            ->join('locations', 'location_id', '=', 'locations.id')
            ->where('companies.mptOK', 1)
            ->select('companies.companyName', 'locations.lat', 'locations.lng')
            ->get();
        return $companies;
    }

    public function getPersons($flock_id){
        $persons = DB::table('persons')
            ->join('locations', 'location_id', '=', 'locations.id')
            ->where('persons.flock_id', $flock_id)
            ->select('persons.initials', 'locations.lat', 'locations.lng')
            ->get();
        return $persons;
    }


}
