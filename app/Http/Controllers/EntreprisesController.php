<?php
/**
 * Created by PhpStorm.
 * User: antonio.giordano
 * Date: 08.01.2018
 * Time: 08:19
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EntreprisesController extends Controller
{
    public function index()
    {
        return view('entreprises/entreprises');
    }
}
