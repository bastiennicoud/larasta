<?php

namespace App\Http\Controllers;

use App\Remark;
use Illuminate\Http\Request;

class RemarksController extends Controller
{
    private $message; // a message to display - if defined - in views
    public function index()
    {
        $remarks = Remark::all();
        return view('remarks/remarks')->with(
            [
                'remarks' => $remarks,
                'message' => $this->message
            ]
        );
    }

    public function filter(Request $request)
    {
        $needle = $request->needle;
        $remarks = Remark::where('remarkText','like',"%$needle%")->get();
        return view('remarks/remarks')->with(
            ['remarks' => $remarks]
        );
    }

    public function create(Request $request) {
        $n = new Remark();
        $n->remarkType = 1;
        $n->remarkOn_id = 1;
        $n->remarkDate = date('Y-m-d H:i:s');
        $n->remarkText = $request->newremtext;
        $n->author = '???';
        $n->save();
        $request->session()->flash('status', 'Remarque ajoutée');
        return redirect('/remarks');
    }

    public function edit (Request $request, $rid) {
        $remark = Remark::where('id',$rid)->first();
        return view('remarks/remark')->with(
            [
                'remark' => $remark,
                'message' => $this->message
            ]
        );
    }

    public function delete (Request $request) {
        $remark = Remark::where('id',$request->delid)->first();
        $remark->delete();
        $this->message = 'Remarque supprimée';
        return $this->index();
    }

    public function update (Request $request) {
        $remark = Remark::where('id',$request->updid)->first();
        $remark->remarkText = $request->updtext;
        $remark->save();
        $request->session()->flash('status', 'Remarque modifiée');
        return redirect('/remarks');
    }
}
