<?php

namespace App\Http\Controllers;

use App\Remark;
use ReflectionObject;

class RemarksController extends Controller
{
    public function index()
    {
        $remarks = Remark::all();
        return view('remarks/remarks')->with(
            ['remarks' => $remarks]
        );
    }

    public function filter()
    {
        $needle = request()->needle;
        $remarks = Remark::where('remarkText','like',"%$needle%")->get();
        return view('remarks/remarks')->with(
            ['remarks' => $remarks]
        );
    }
}
