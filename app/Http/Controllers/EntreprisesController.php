<?php
/**
 * Created by PhpStorm.
 * User: antonio.giordano
 * Date: 08.01.2018
 * Time: 08:19
 */

namespace App\Http\Controllers;
use CPNVEnvironment\Environment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EntreprisesController extends Controller
{
    public function index()
    {
        $user = Environment::currentUser();

        $companies = DB::table('companies')
            ->join('locations', 'location_id', '=', 'locations.id')
            ->select('companies.id','companyName','address1','address2','postalCode','city')
            ->get();

        return view('entreprises/entreprises')->with(['companies' => $companies, 'user' => $user]);
    }

    public function getCompanies(){

    }

    public function add(Request $request){

        $id = DB::table('locations')->insertGetId(['address1'=>null]);

        DB::table('companies')->insertGetId(
            ['companyName' => $request->nameE, 'contracts_id' => 3,'location_id'=>$id]
        );


        return $this->index();
    }


}
