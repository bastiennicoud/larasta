<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/// Author : Kevin Jordil 2018


class TravelTimeController extends Controller
{
    private $message; // a message to display - if defined - in views
    private $unknowChar = "0"; // unknow char is when the time is unknow, define this char

    /// Calculate the traveltime for a class and add it to Database
    public function calculate($flockId){

        $companies = $this->getCompaniesDB();
        $persons = $this->getPersonsDB($flockId);
        $persons = $this->checkPersons($persons);
        $travelTimes = $this->getTravelTime($companies, $persons);
        $error = $this->checkGoogleAPI($travelTimes);

        if($error != null){
            return view('traveltime/traveltime')->with(
                [
                    "message" => $error,
                    "error" => true
                ]
            );
        }

        $times = $this->extractTimes($travelTimes);
        $this->addDataDB($times, $companies, $persons);

        $colors = $this->colorTimes($times);

        $message = "Classe calculée !";

        return view('traveltime/traveltime')->with(
            [
                "companies" => $companies,
                "persons" => $persons,
                "times" => $times,
                "colors" => $colors,
                "flockId" => $flockId,
                "message" => $message,
                "error" => false
            ]
        );
    }

    /// load data from DB
    public function load($flockId){
        $companies = $this->getCompaniesDB();
        $persons = $this->getPersonsDB($flockId);
        $persons = $this->checkPersons($persons);
        $times = array();

        foreach ($companies as $company){
            foreach( $persons as $person){

                $traveltime = $this->getTravelTimeDB($person->id, $company->internships_id);
                if (isset($traveltime[0]))
                {
                    array_push($times, $traveltime[0]->travelTime);
                }
                else{
                    array_push($times, $this->unknowChar);
                }
            }
        }


        $colors = $this->colorTimes($times);
        $message = "Chargement réussi";

        return view('traveltime/traveltime')->with(
            [
                "companies" => $companies,
                "persons" => $persons,
                "times" => $times,
                "colors" => $colors,
                "flockId" => $flockId,
                "message" => $message,
                "error" => false
            ]
        );

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
                    if(isset($persons[$i])){
                        $destinations[$iteration] .= $persons[$i]->lat.",".$persons[$i]->lng."|";
                    }
                }
            }
            $iteration++;
        }
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////



        $timestamp = $this->getTimestamp();
        // GET Date of tommorow 8 o'clock in seconds


        //////////////////////////Do requests at Google API and create an array with all datas///////////////////////////
        $travelTime = array();
        foreach ($origins as $origin){
            foreach($destinations as $destination){


                $url="https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$origin."&destinations=".$destination."&mode=transit&arrival_time=".$timestamp."&key=AIzaSyCX4-tZ3inw_77Y23l4e7_zvqZ-2EMDHyg"; //.$_ENV['API_GOOGLE_MAP'];
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
        $times = array();
        foreach($travelTimes as $travelTime){
            foreach ($travelTime["rows"] as $row){
                foreach ($row["elements"] as $element){
                    if (isset($element["duration"]["value"])) {
                        array_push($times, round($element["duration"]["value"]/60));
                    }
                    else{
                        array_push($times, $this->unknowChar);
                    }
                }
            }
        }
        return $times;
    }

    /// Control Persons, delete empty lat lng user
    public function checkPersons($persons){
        foreach($persons as $key  => $person) {
            if ($person->lat == null or $person->lng == null) {
                unset($persons[$key]);
            }
        }

        $newPersons = array();
        $i=0;
        foreach ($persons as $person){
            $newPersons[$i] = $person;
            $i++;
        }

        return $newPersons;
    }

    /// Check if we have a problem with request
    /// the most popular message it's daily quota end
    public function checkGoogleAPI($travelTimes){
        if(isset($travelTimes[count($travelTimes)-1]["error_message"])) {
            return $travelTimes[count($travelTimes)-1]["error_message"];
        }
        return null;
    }

    /// Define wich color class the time have
    /// the function take the higher number and define range for every color
    /// Return a colors array with same id as $times
    public function colorTimes($times){
        $maxValue = max($times);
        $ratio = $maxValue/5;
        $range1 = $ratio*1;
        $range2 = $ratio*2;
        $range3 = $ratio*3;
        $range4 = $ratio*4;
        $range5 = $ratio*5;
        $colors = $times;
        foreach ($times as $key => $time){
            try{
                switch (true){
                    case $time == 0:
                        $colors[$key] = "";
                        break;
                    case $time < $range1:
                        $colors[$key] = "color1";
                        break;
                    case $time < $range2:
                        $colors[$key] = "color2";
                        break;
                    case $time < $range3:
                        $colors[$key] = "color3";
                        break;
                    case $time < $range4:
                        $colors[$key] = "color4";
                        break;
                    case $time <= $range5:
                        $colors[$key] = "color5";
                        break;
                    default:
                        $colors[$key] = "";
                        break;
                }
            }
            catch(\Exception $e){}
        }
        return $colors;

    }

    /// Add Data to Database
    /// By companies and persons, add the good times in DB
    public function addDataDB($times, $companies, $persons){
        $i=0;
        foreach ($companies as $company){
            foreach ($persons as $person){
                if($times[$i] != $this->unknowChar) {
                    DB::table('wishes')
                        ->join('internships', 'wishes.internships_id', '=', 'internships.id')
                        ->where('wishes.persons_id', $person->id)
                        ->where('internships.id', $company->internships_id)
                        ->update(['wishes.travelTime' => $times[$i]]);
                }
                else{
                    DB::table('wishes')
                        ->join('internships', 'wishes.internships_id', '=', 'internships.id')
                        ->where('wishes.persons_id', $person->id)
                        ->where('internships.id', $company->internships_id)
                        ->update(['wishes.travelTime' => 0]);

                }
                $i++;
            }
        }
    }

    /// Get companies infos from Database
    public function getCompaniesDB(){
        $companies = DB::table('companies')
            ->join('internships', 'internships.companies_id', '=', 'companies.id')
            ->join('locations', 'location_id', '=', 'locations.id')
            ->where('companies.mptOK', 1)
            ->whereYear('internships.beginDate', '=', date('Y'))
            ->select('internships.id as internships_id', 'companies.id', 'companies.companyName', 'locations.lat', 'locations.lng')
            ->get();

        return $companies;
    }

    /// Get persons infos from Database
    public function getPersonsDB($flock_id){
        $persons = DB::table('persons')
            ->join('locations', 'location_id', '=', 'locations.id')
            ->join('flocks', 'persons.flock_id', '=', 'flocks.id')
            ->whereNotNull('locations.lat')
            ->whereNotNull('locations.lng')
            ->where('persons.flock_id', $flock_id)
            ->select('persons.id', 'persons.initials', 'locations.lat', 'locations.lng')
            ->get();
        return $persons;
    }

    /// Get wishes from Database
    public function getTravelTimeDB($idPerson, $idInternships){
        $travelTimes = DB::table('wishes')
            ->where('wishes.persons_id', $idPerson)
            ->where('wishes.internships_id', $idInternships)
            ->select('wishes.travelTime')
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
