<?php

namespace App\Http\Controllers;

use App\Datamodel\Remark;
use ReflectionObject;

class RemarksController extends Controller
{
    private $persons = ['Joe', 'Jack', 'William', 'Averell'];
    private $hellos = ['hello','salut','bonjour','tcho'];

    public function index()
    {
        for ($i=0; $i<10; $i++)
        {
            $pchoice = rand(0,count($this->persons)-1);
            $hchoice = rand(0,count($this->hellos)-1);
            $remarks[] = new Remark(date("d.m"), $this->persons[$pchoice], 'Dit '.$this->hellos[$hchoice]);
        }

        return view('remarks/remarks')->with(
            ['remarks' => $remarks]
        );
    }
}
