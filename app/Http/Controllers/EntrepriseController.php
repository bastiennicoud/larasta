<?php

namespace App\Http\Controllers;
use CPNVEnvironment\Environment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EntrepriseController extends Controller
{
    public function index($id){
        $user = Environment::currentUser();

        $company = DB::table('companies')
            ->join('locations', 'location_id', '=', 'locations.id')
            ->join('contracts', 'contracts_id','=', 'contracts.id')
            ->select('companyName','address1','address2','postalCode','city','contractType')
            ->where('companies.id','=',$id)
            ->get();

        $persons = DB::table('persons')
            ->select('firstname', 'lastname', 'id', 'obsolete')
            ->where('company_id','=',$id)
            ->get();

        $contacts = DB::table('contactinfos')
            ->join('persons','persons.id','=','persons_id')
            ->select('contacttypes_id','value','firstname','lastname','persons.id as personId')
            ->where('company_id','=',$id)
            ->get();


        $trainee = DB::table('persons')
            ->join('internships', 'persons.id','=','intern_id')
            ->select('firstname', 'lastname','persons.id', 'beginDate','endDate','admin_id','intern_id','responsible_id')
            ->where('companies_id','=',$id)
            ->get();

        return view('entreprises/entreprise')->with(['company' => $company, 'user' => $user, 'persons' => $persons, 'contacts' => $contacts,  'trainee'=>$trainee]);
    }
}
