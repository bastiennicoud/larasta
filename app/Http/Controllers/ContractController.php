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
        return view('contract/contractGenerated')->with(['iDate' => $iDate, 'iid' => $iid]);
    }

    public function visualizeContract($iid)
    {
        $contract = $this->getContract($iid);
        return view('contract/contractVisualize')->with(['iid' => $iid, 'contract' => $contract]);
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
        $contract = DB::table('contracts')
            ->join('companies', 'contracts_id', '=', 'contracts.id')
            ->join('internships', 'companies_id', '=', 'companies.id')
            ->select('contracttext')
            ->where('internships.id', $iid)
            ->first();

        return $contract;
    }
}
