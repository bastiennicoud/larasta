<?php

namespace App\Http\Controllers;

use App\Remark;
use Illuminate\Http\Request;

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

    public function calculate(Request $request){
        $url="https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$request->origin."&destinations=".$request->destination."&mode=transit&key=".$_ENV['API_GOOGLE_MAP'];
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

}
