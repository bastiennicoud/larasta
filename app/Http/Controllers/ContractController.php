<?php

/**
 * Author : Quentin Neves
 * Created : 12.12.2017
 * Updated : 15.01.2018
 */


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{
    public function index()
    {
        //
    }

    public function generateContract($iid)
    {
        $iDate = $this->getStageDate($iid);
        return view('contract/contractGenerated')->with('iDate', $iDate);
    }

    public function visualizeContract($iid)
    {
        return view('contract/contract/'. $iid .'/view}');
    }

    public function getStageDate($iid)
    {
        $iDate = DB::table('internships')
            ->select('contractGenerated')
            ->where('id', $iid)
            ->first();

        return $iDate;
    }

    public  function getContract($iid)
    {

    }
}
