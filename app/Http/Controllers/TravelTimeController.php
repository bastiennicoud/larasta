<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use CPNVEnvironment\Environment;

/// Author : Kevin Jordil 2018


class TravelTimeController extends Controller
{
    protected $message; // a message to display - if defined - in views
    protected $unknowChar = "0"; // unknow char is when the time is unknow, define this char
    protected $limitElementGoogle = 10; // Maximum d'element requete google

    /// Calculate the traveltime for a class and add it to Database
    public function calculate($flockId){

        if(!$this->haveAccess()){
            return view('traveltime/traveltime')->with(
                [
                    "message" => "Accès refusé",
                    "error" => true
                ]
            );
        }

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

        $times = $this->extractTimes($travelTimes, $companies, $persons);
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

        if(!$this->haveAccess()){
            return view('traveltime/traveltime')->with(
                [
                    "message" => "Accès refusé",
                    "error" => true
                ]
            );
        }

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


        $origins = $this->splitArray($companies, $this->limitElementGoogle);
        $destinations = $this->splitArray($persons, $this->limitElementGoogle);

        // GET Date of tommorow 8 o'clock in seconds
        $timestamp = $this->getTimestamp();


        //////////////////////////Do requests at Google API and create an array with all datas///////////////////////////
        $travelTime = array();
        foreach($destinations as $destination){
            foreach ($origins as $origin){


                $url="https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$origin."&destinations=".$destination."&mode=transit&arrival_time=".$timestamp."&key=".$_ENV['API_GOOGLE_MAP'];
                $json = file_get_contents($url);
                $actualTravel = json_decode($json, true);
                array_push($travelTime, $actualTravel);
                sleep(1);
            }
        }
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

        return $travelTime;


    }

    /// Split array for Google API limit
    public function splitArray($array, $nb){
        $iteration = 0;
        $res=count($array)/$nb;
        $it=null;
        if(is_float($res)){$it = intval($res)+1;}
        else{$it=$res;}

        $result = array_fill(0, $it, NULL);

        for($j=0 ; $j<$it ; $j++){
            for($i=$iteration*$nb ; $i<$iteration*$nb+$nb ; $i++){
                if($i>count($array)-1){
                    break;
                }
                else{
                    $result[$iteration] .= $array[$i]->lat.",".$array[$i]->lng."|";
                }
            }
            $iteration++;
        }
        return $result;

    }

    /// Extract times from PHP array and return an array
    public function extractTimes($travelTimes, $companies, $persons){
        $times = array();

        $origins = $this->splitArray($companies, $this->limitElementGoogle);
        $destinations = $this->splitArray($persons, $this->limitElementGoogle);


        $tempCol = collect($travelTimes);
        $tempCol = $tempCol->sortByDesc('destination_addresses');
        $travelTimes = $tempCol->sortByDesc('rows')->all();



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


        //dd($sorted);

        /*

        foreach($travelTimes as $travelTime){
            for($i=0 ; $i<10; $i++){
                if(isset($travelTime["rows"][$i])) {
                    foreach ($travelTime["rows"][$i]["elements"] as $element) {
                        if (isset($element["duration"]["value"])) {
                            array_push($times, round($element["duration"]["value"] / 60));
                        } else {
                            array_push($times, $this->unknowChar);
                        }
                    }
                }
                else{
                    array_push($times, $this->unknowChar);
                }
            }

        }
        */
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

    /// Return the timestamp (time in seconds from 1 january 1970) from the next open day at 8 o'clock
    public function getTimestamp(){
        $datetoday = date('Y-m-d', time());
        $date = date('Y-m-d H:i:s', strtotime($datetoday . ' +1 Weekday +7 hours'));
        return strtotime($date);
    }

    /// Check if the actual user have access to this page
    public function haveAccess(){
        // !!!!!!!!!!!! Test Value !!!!!!!!!!!!!!!!!!!!!!!!!!
        $currentUserTest = Environment::currentUser();
        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

        $currentUser = $this->getCurrentUser($currentUserTest->getId());
        if ($currentUser->role!=1){
            return false;
        }
        else{
            return true;
        }
    }

    /// Add Data to Database
    /// By companies and persons, add the good times in DB
    public function addDataDB($times, $companies, $persons){
        $i=0;
        foreach ($companies as $company){
            foreach ($persons as $person){

                $exists = DB::table('wishes')
                    ->where('wishes.persons_id', $person->id)
                    ->where('wishes.internships_id', $company->internships_id)
                    ->first();

                if($times[$i] != $this->unknowChar) {
                    if(!$exists){
                        DB::table('wishes')->insert([
                            ['internships_id' => $company->internships_id,
                                'persons_id' => $person->id,
                                'rank' => 0,
                                'workPlaceDistance' => 0,
                                'travelTime' => $times[$i],
                                'application' => 1
                                ]
                        ]);
                    }
                    else{
                        DB::table('wishes')
                            ->where('wishes.persons_id', $person->id)
                            ->where('wishes.internships_id', $company->internships_id)
                            ->update(['wishes.travelTime' => $times[$i]]);
                    }
                }
                else{
                    if(!$exists){
                        DB::table('wishes')->insert([
                            ['internships_id' => $company->internships_id,
                                'persons_id' => $person->id,
                                'rank' => 0,
                                'workPlaceDistance' => 0,
                                'travelTime' => $this->unknowChar,
                                'application' => 1
                            ]
                        ]);
                    }
                    else{
                        DB::table('wishes')
                            ->where('wishes.persons_id', $person->id)
                            ->where('wishes.internships_id', $company->internships_id)
                            ->update(['wishes.travelTime' => $this->unknowChar]);
                    }
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
            ->orderBy('companies.id', 'asc')
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
            ->orderBy('persons.id', 'asc')
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

    /// Get the actual connected user
    private function getCurrentUser($personId)
    {
        $persons = DB::table('persons')
            ->where('persons.id', $personId)
            ->whereNotNull('persons.initials')
            ->select('persons.id','persons.initials', 'persons.flock_id', 'persons.role')
            ->first();
        return $persons;
    }

}
