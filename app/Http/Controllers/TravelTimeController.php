<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;




class TravelTimeController extends Controller
{
    private $message; // a message to display - if defined - in views

    public function index($result=null, $error=false)
    {
        $companies = $this->getCompanies();
        $persons = $this->getPersons(12);



        $travelTimes = $this->getTravelTime($companies, $persons);
        //dd($travelTimes);
        $times = $this->extractTimes($travelTimes);
        //dd($times);

        return view('traveltime/traveltime')->with(
            [
                "persons" => $persons,
                "companies" => $companies,
                "times" => $times,
                "result" => $result,
                "error" => $error
            ]
        );
    }


    public function getTravelTime($companies, $persons){

        $nbOfElement=10;

        $iteration = 0;
        $res=count($companies)/$nbOfElement;
        $it=null;
        if(is_float($res)){$it = intval($res)+1;}
        else{$it=$res;}

        $destinations = array_fill(0, $it, NULL);

        for($j=0 ; $j<$it ; $j++){
            for($i=$iteration*$nbOfElement ; $i<$iteration*$nbOfElement+$nbOfElement ; $i++){
                if($i>count($companies)-1){
                    break;
                }
                else{
                    $destinations[$iteration] .= $companies[$i]->lat.",".$companies[$i]->lng."|";
                }
            }
            $iteration++;
        }

        $iteration = 0;
        $res=count($persons)/$nbOfElement;
        $it=null;
        if(is_float($res)){$it = intval($res)+1;}
        else{$it=$res;}

        $origins = array_fill(0, $it, NULL);

        for($j=0 ; $j<$it ; $j++){
            for($i=$iteration*$nbOfElement ; $i<$iteration*$nbOfElement+$nbOfElement ; $i++){
                if($i>count($persons)-1){
                    break;
                }
                else{
                    $origins[$iteration] .= $persons[$i]->lat.",".$persons[$i]->lng."|";
                }
            }
            $iteration++;
        }

        $timestamp = $this->getTimestamp();

        $travelTime = [];
        foreach ($origins as $origin){
            foreach($destinations as $destination){


                $url="https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$origin."&destinations=".$destination."&mode=transit&arrival_time=".$timestamp."&key=AIzaSyDH4cvx4vAJBOvUrv0uCKK3kDfY1cr3q7c"; //.$_ENV['API_GOOGLE_MAP'];
                $json = file_get_contents($url);
                $actualTravel = json_decode($json, true);
                array_push($travelTime, $actualTravel);
                sleep(1);
            }
        }

        return $travelTime;


    }

    public function extractTimes($travelTimes){
        $times = [];
        foreach($travelTimes as $travelTime){
            foreach ($travelTime["rows"] as $row){
                foreach ($row["elements"] as $element){
                    if (isset($element["duration"]["value"])) {
                        array_push($times, round($element["duration"]["value"]/60, 2));
                    }
                    else{
                        array_push($times, "?");
                    }
                }
            }
        }
        return $times;
        //DB::table('wishes')
        //    ->where('internships_id', $internshipsId)
        //    ->where('persons_id', $personsId)
        //    ->update(array('travelTime' => $travelTime));
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

    // return the timestamp (time in seconds from 1 january 1970) from the next open day at 8 o'clock
    public function getTimestamp(){
        $datetoday = date('Y-m-d', time());
        $date = date('Y-m-d H:i:s', strtotime($datetoday . ' +1 Weekday +7 hours'));
        return strtotime($date);
    }


}
