<?php

/**
 * Author :         Quentin Neves
 * Created :        12.12.2017
 * Updated :        15.01.2018
 * Description :    This controller is used for generating internship contract using intern informations and gender
 *                  and display it
 */


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContractController extends Controller
{
    public function index()
    {
        //
    }

    public function generateContract($iid)
    {
        $iDate = $this->getStageDate($iid);
        return view('contract/contractGenerate')->with(['iDate' => $iDate, 'iid' => $iid]);
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

    public function saveContract($iid, Request $request)
    {
        $date = Carbon::now();

        DB::table('internships')
            ->where('id', $iid)
            ->update(['contractGenerated' => $date]);

        $contract = DB::table('contracts')
            ->join('companies', 'contracts_id', '=', 'contracts.id')
            ->join('internships', 'companies_id', '=', 'companies.id')
            ->where('internships.id', $iid)
            ->update(['contractText' => $request->contractText]);

        return $this->generateContract($iid);
    }

    public function cancelContract($iid)
    {
        DB::table('internships')
            ->where('id', $iid)
            ->update(['contractGenerated' => null]);

        return $this->generateContract($iid);
    }
}
