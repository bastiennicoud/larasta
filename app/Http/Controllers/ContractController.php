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

        /*
         * TODO: Fill the switch case
         * TODO: Find out why str_replace doesn't replace anything since $markup come from $contract->contractText
         */
        foreach ($out[0] as $markup) // For each markup found
        {
            if (substr($markup,0,2) === '{{') // If we must accord the gender
            {
                if ($request->gender === 'male')
                {
                    str_replace($markup, $out[1][$i], $contract[0]->contractText);
                }
                else
                {
                    str_replace($markup, $out[2][$i], $contract[0]->contractText);
                }

            }
            else // else we must insert data
            {
                switch ($out){
                    case 'train_PrenomPersonne':
                        str_replace($out[0][$i], $out[1][$i], $contract[0]->contractText);
                        break;
                    // And so on...
                }
            }
            $i++;
        }

        /*
         * Abandoned because way too complex for this case with my skills, used preg_match_all and str_replace instead
         *
        // Search all matches for this regex, then replace them depending on gender and kind of data
        $contract[0]->contractText = preg_replace_callback(
            "/{{1,2}([^{}|]+)\s*(?:\|\s*([^{}]+))?}{1,2}/",
            function ($matches) use ($request){
                if ($request->gender === 'male')
                {

                }
                else
                {
                    // female
                }

                return $matches[1][0];
            },
            $contract[0]->contractText
        );*/

        return view('contract/contractVisualize')->with(['iid' => $iid, 'contract' => $contract, 'out' => $out]);
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

        DB::table('contracts')
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
