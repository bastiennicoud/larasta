<?php
//------------------------------------------------------------
// Benjamin Delacombaz
// version 1.0
// WishesMatrixController
// Created 18.12.2017
// Last edit 18.12.2017 by Benjamin Delacombaz
//------------------------------------------------------------

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WishesMatrixController extends Controller
{
    public function index()
    {
        return view('wishesMatrix/wishesMatrix');
    }
}
