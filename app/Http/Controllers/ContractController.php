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
use PDF;

class ContractController extends Controller
{
    public function index()
    {
        //
    }

    public function generateContract($iid)
    {
        $iDate = $this->getStageDate($iid);
        $contract = $this->getContract($iid);
        return view('contract/contractGenerate')->with(['iDate' => $iDate, 'iid' => $iid, 'contract' => $contract]);
    }

    public function visualizeContract($iid, Request $request)
    {


        $contract = $this->getContract($iid);

        /*
         *  Search for anything between { } and trim them by groups so $out[] contains :
         *      0 => Markups to replace
         *      1 => Replacing string, male
         *      2 => Only contains female replacing string
         */
        preg_match_all("/{{1,2}([^{}|]+)\s*(?:\|\s*([^{}]+))?}{1,2}/", $contract[0]->contractText, $out);

        // Tracks on which regex match we're working with
        $i = 0;

        foreach ($out[0] as $markup) // For each markup found
        {
            if (substr($markup,0,2) === '{{') // If we must accord the gender
            {
                if ($request->gender === 'male')
                {
                    $contract[0]->contractText = str_replace($markup, $out[1][$i], $contract[0]->contractText);
                }
                else
                {
                    $contract[0]->contractText = str_replace($markup, $out[2][$i], $contract[0]->contractText);
                }

            }
            else // else we must insert data
            {
                switch ($out[0][$i]){
                    case '{train_PrenomPersonne}':
                        $contract[0]->contractText = str_replace($out[0][$i], $contract[1]->firstname, $contract[0]->contractText);
                        error_log($request);
                        break;
                    case '{train_NomPersonne}':
                        $contract[0]->contractText = str_replace($out[0][$i], $contract[1]->lastname, $contract[0]->contractText);
                        error_log($request);
                        break;
                    case '{train_Adresse1}':
                        $contract[0]->contractText = str_replace($out[0][$i], $contract[1]->address1, $contract[0]->contractText);
                        error_log($request);
                        break;
                    case '{train_Adresse2}':
                        $contract[0]->contractText = str_replace($out[0][$i], $contract[1]->address2, $contract[0]->contractText);
                        error_log($request);
                        break;
                    case '{train_NPA}':
                        $contract[0]->contractText = str_replace($out[0][$i], $contract[1]->postalCode, $contract[0]->contractText);
                        error_log($request);
                        break;
                    case '{train_Localite}':
                        $contract[0]->contractText = str_replace($out[0][$i], $contract[1]->city, $contract[0]->contractText);
                        error_log($request);
                        break;
                    case '{corp_NomEntreprise}':
                        $contract[0]->contractText = str_replace($out[0][$i], $contract[2]->companyName, $contract[0]->contractText);
                        error_log($request);
                        break;
                    case '{corp_Adresse1}':
                        $contract[0]->contractText = str_replace($out[0][$i], $contract[1]->address1, $contract[0]->contractText);
                        error_log($request);
                        break;
                    case '{corp_Adresse2}':
                        $contract[0]->contractText = str_replace($out[0][$i], $contract[1]->address2, $contract[0]->contractText);
                        error_log($request);
                        break;
                    case '{corp_NPA}':
                        $contract[0]->contractText = str_replace($out[0][$i], $contract[1]->postalCode, $contract[0]->contractText);
                        error_log($request);
                        break;
                    case '{corp_Localite}':
                        $contract[0]->contractText = str_replace($out[0][$i], $contract[1]->city, $contract[0]->contractText);
                        error_log($request);
                        break;
                    case '{Debut}':
                        $contract[0]->contractText = str_replace($out[0][$i], date('d-m-Y', strtotime($contract[0]->beginDate)), $contract[0]->contractText);
                        error_log($request);
                        break;
                    case '{Fin}':
                        $contract[0]->contractText = str_replace($out[0][$i], date('d-m-Y', strtotime($contract[0]->endDate)), $contract[0]->contractText);
                        error_log($request);
                        break;
                    case '{resp_PrenomPersonne}':
                        $contract[0]->contractText = str_replace($out[0][$i], $contract[3]->firstName, $contract[0]->contractText);
                        error_log($request);
                        break;
                    case '{resp_NomPersonne}':
                        $contract[0]->contractText = str_replace($out[0][$i], $contract[3]->lastName, $contract[0]->contractText);
                        error_log($request);
                        break;
                    case '{SalaireBrut}':
                        $contract[0]->contractText = str_replace($out[0][$i], $contract[0]->grossSalary, $contract[0]->contractText);
                        error_log($request);
                        break;
                    case '{date}':
                        $date = Carbon::now();
                        $contract[0]->contractText = str_replace($out[0][$i], date('d-m-Y', strtotime($date)), $contract[0]->contractText);
                        error_log($request);
                        break;
                }
            }
            $i++;
        }

        return view('contract/contractVisualize')->with(['iid' => $iid, 'contract' => $contract, 'out' => $out, 'request' => $request]);
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
            ->select('contractText', 'grossSalary','internships.beginDate', 'internships.endDate')
            ->where('internships.id', $iid)
            ->first();

        $intern = DB::table('persons')
            ->join('internships', 'intern_id', '=', 'persons.id')
            ->join('locations', 'location_id', '=', 'locations.id')
            ->where('internships.id', $iid)
            ->select('firstname', 'lastname', 'locations.address1', 'locations.address2', 'locations.postalCode', 'locations.city')
            ->first();

        $company = DB::table('companies')
            ->join('internships', 'companies_id', '=', 'companies.id')
            ->join('locations', 'location_id', '=', 'locations.id')
            ->where('internships.id', $iid)
            ->select('companyName', 'locations.address1', 'locations.address2', 'locations.postalCode', 'locations.city')
            ->first();

        $responsible = DB::table('persons')
            ->join('internships', 'responsible_id', '=', 'persons.id')
            ->where('internships.id', $iid)
            ->select('firstName', 'lastName')
            ->first();

        return array($contract, $intern, $company, $responsible);
    }

    public function saveContract($iid, Request $request)
    {
        $date = Carbon::now();

        DB::table('internships')
            ->where('id', $iid)
            ->update(['contractGenerated' => $date]);

        if ($request->replace)
        {
            DB::table('contracts')
                ->join('companies', 'contracts_id', '=', 'contracts.id')
                ->join('internships', 'companies_id', '=', 'companies.id')
                ->where('internships.id', $iid)
                ->update(['contractText' => $request->contractText]);
        }

        if ($request->pdf == 'pdf')
        {
            $pdf = new PDF(); // replace garryvdh/laravel-dompdf by dompdf/dompdf because garry wants you to transform a view to a pdf...
        }

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
