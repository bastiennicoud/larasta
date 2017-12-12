<?php
// *************************************************
// Bastien
// version 1.0
// EvalController

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EvalController extends Controller
{
    // index, base route
    public function index()
    {
        return view('evalGrid/grid');
    }
}
