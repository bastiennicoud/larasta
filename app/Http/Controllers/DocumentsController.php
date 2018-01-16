<?php
//------------------------------------------------------------
// Nicolas Henry
// SI-T1a
// DocumentsController.php
//------------------------------------------------------------


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentsController extends Controller
{
    // index, base route
    public function index()
    {
        return view('documents/documents');
    }
}

?>