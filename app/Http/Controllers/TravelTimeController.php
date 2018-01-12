<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;




class TravelTimeController extends Controller
{
    private $message; // a message to display - if defined - in views

    public function index($result=null, $error=false)
    {

        return view('traveltime/traveltime')->with(
            [
                "result" => $result,
                "error" => $error
            ]
        );
    }

    /// Calculate the traveltime for a class and add it to Database
    public function calculate(Request $request){

        //Actually i put this because they are some problems
        return view('traveltime/traveltime')->with(
            [
                "result" => null,
                "error" => false
            ]
        );

        $companies = $this->getCompaniesDB();
        $persons = $this->getPersonsDB($request->flockID);
        $travelTimes = $this->getTravelTime($companies, $persons);
        $times = $this->extractTimes($travelTimes);
        $this->addDataDB($times, $companies, $persons);

        return view('traveltime/traveltime')->with(
            [
                "companies" => $companies,
                "persons" => $persons,
                "times" => $times,
                "result" => null,
                "error" => false
            ]
        );
    }

    public function load(Request $request){
        $companies = $this->getCompaniesDB();
        $persons = $this->getPersonsDB($request->flockID);
        $times = [];
        foreach( $persons as $person){
            array_push($times, $this->getTravelTimeDB($person->id));
        }
        dd($times);
    }


    /// Add Data to Database
    /// By companies and persons, add the good times in DB
    public function addDataDB($times, $companies, $persons){
        foreach ($companies as $key => $companie){
            $j=0;
            for($i = $key*count($persons) ; $i < ($key*count($persons))+count($persons); $i++){
                DB::table('wishes')
                    ->join('internships', 'wishes.internships_id', '=', 'internships.id')
                    ->where('wishes.persons_id', $persons[$j]->id)
                    ->where('internships.companies_id', $companie->id)
                    ->update(['wishes.travelTime' => date('H:i:s', intval($times[$i]))]);
                $j++;
            }
        }
    }


    /// Get Travel by Google API
    /// Return an array with all JSON from google API Distance matrix
    public function getTravelTime($companies, $persons){

        $nbOfElement=10;

        /////////////////////////////////Extract companies and do array with a fix size/////////////////////////////////
        $iteration = 0;
        $res=count($companies)/$nbOfElement;
        $it=null;
        if(is_float($res)){$it = intval($res)+1;}
        else{$it=$res;}

        $origins = array_fill(0, $it, NULL);

        for($j=0 ; $j<$it ; $j++){
            for($i=$iteration*$nbOfElement ; $i<$iteration*$nbOfElement+$nbOfElement ; $i++){
                if($i>count($companies)-1){
                    break;
                }
                else{
                    $origins[$iteration] .= $companies[$i]->lat.",".$companies[$i]->lng."|";
                }
            }
            $iteration++;
        }
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////


        /////////////////////////////Extract companies and do array with a fix size persons/////////////////////////////
        $iteration = 0;
        $res=count($persons)/$nbOfElement;
        $it=null;
        if(is_float($res)){$it = intval($res)+1;}
        else{$it=$res;}

        $destinations = array_fill(0, $it, NULL);

        for($j=0 ; $j<$it ; $j++){
            for($i=$iteration*$nbOfElement ; $i<$iteration*$nbOfElement+$nbOfElement ; $i++){
                if($i>count($persons)-1){
                    break;
                }
                else{
                    $destinations[$iteration] .= $persons[$i]->lat.",".$persons[$i]->lng."|";
                }
            }
            $iteration++;
        }
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////



        $timestamp = $this->getTimestamp();
        // GET Date of tommorow 8 o'clock in seconds


        //////////////////////////Do requests at Google API and create an array with all datas///////////////////////////
        $travelTime = [];
        foreach ($origins as $origin){
            foreach($destinations as $destination){


                $url="https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$origin."&destinations=".$destination."&mode=transit&arrival_time=".$timestamp."&key=AIzaSyDGKtvzU-EsYTykwKR-ApMrlycEG30PyIg"; //.$_ENV['API_GOOGLE_MAP'];
                $json = file_get_contents($url);
                $actualTravel = json_decode($json, true);
                array_push($travelTime, $actualTravel);
                sleep(1);
            }
        }
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////


        return $travelTime;


    }

    /// Extract times from PHP array and return an array
    public function extractTimes($travelTimes){
        $times = [];
        foreach($travelTimes as $travelTime){
            foreach ($travelTime["rows"] as $row){
                foreach ($row["elements"] as $element){
                    if (isset($element["duration"]["value"])) {
                        array_push($times, $element["duration"]["value"]);
                    }
                    else{
                        array_push($times, "?");
                    }
                }
            }
        }
        return $times;
    }

    /// Get companies infos from Database
    public function getCompaniesDB(){
        $companies = DB::table('companies')
            ->join('locations', 'location_id', '=', 'locations.id')
            ->where('companies.mptOK', 1)
            ->select('companies.id', 'companies.companyName', 'locations.lat', 'locations.lng')
            ->get();
        return $companies;
    }

    /// Get persons infos from Database
    public function getPersonsDB($flock_id){
        $persons = DB::table('persons')
            ->join('locations', 'location_id', '=', 'locations.id')
            ->where('persons.flock_id', $flock_id)
            ->select('persons.id', 'persons.initials', 'locations.lat', 'locations.lng')
            ->get();
        return $persons;
    }

    /// Get wishes from Database
    public function getTravelTimeDB($idPerson){
        $travelTimes = DB::table('wishes')
            ->join('internships', 'wishes.internships_id', '=', 'internships.id')
            ->join('companies', 'internships.companies_id', '=', 'companies.id')
            ->where('wishes.persons_id', $idPerson)
            ->select('wishes.travelTime', 'companies.id', 'companies.companyName', 'wishes.persons_id')
            ->get();
        return $travelTimes;
    }


    /// return the timestamp (time in seconds from 1 january 1970) from the next open day at 8 o'clock
    public function getTimestamp(){
        $datetoday = date('Y-m-d', time());
        $date = date('Y-m-d H:i:s', strtotime($datetoday . ' +1 Weekday +7 hours'));
        return strtotime($date);
    }


}
