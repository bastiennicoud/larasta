<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContractController extends Controller
{
    public function index()
    {
        return view('contract/contractGender');
    }

    public function genderSelect()
    {
        return view('contract/contractGender');
    }

    public function getStages()
    {
        $stages = DB::table('');
    }
}
