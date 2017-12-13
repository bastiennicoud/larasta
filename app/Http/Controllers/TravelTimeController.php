<?php

namespace App\Http\Controllers;

use App\Remark;
use Illuminate\Http\Request;

class TravelTimeController extends Controller
{
    private $message; // a message to display - if defined - in views
    public function index()
    {
        return view('traveltime/traveltime')->with(
            [
            ]
        );
    }
}