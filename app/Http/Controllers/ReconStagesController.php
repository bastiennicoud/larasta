<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReconStagesController extends Controller
{
    // index, base route
    public function index()
    {
        return view('reconstages/reconstages');

    }
}
