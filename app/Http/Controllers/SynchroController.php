<?php
/*
 * Title : SynchroController.php
 * Author : Steven Avelino
 * Creation Date : 12 December 2017
 * Modification Date : 16 December 2017
 * Version : 0.1
 * Controller for the Synchronisation between the intranet API and this application
*/

namespace App\Http\Controllers;

use App\Synchro;
use Illuminate\Http\Request;

class SynchroController extends Controller
{
    public function index()
    {
        $synchro = new Synchro();

        $intranet = $synchro->find('all');

        return view('synchro/index')->with([ 'intranet' => $intranet ]);
    }
}