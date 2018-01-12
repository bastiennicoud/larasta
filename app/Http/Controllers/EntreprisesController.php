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
        EntreprisesController::getCompanies();
    }

    public function getCompanies(){
        $user = Environment::currentUser();

        $companies = DB::table('companies')
            ->join('locations', 'location_id', '=', 'locations.id')
            ->select('companies.id','companyName','address1','address2','postalCode','city')
            ->get();

        return view('entreprises/entreprises')->with(['companies' => $companies, 'user' => $user]);
    }

    public function entreprises(Request $request){
        var_dump($request);
    }


}
