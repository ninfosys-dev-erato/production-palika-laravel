<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\JudicialCommittee;

class JudicialCommitteeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:judicial_committees view')->only('index');
        //$this->middleware('permission:judicial_committees edit')->only('edit');
        //$this->middleware('permission:judicial_committees create')->only('create');
    }

    function index(Request $request){
        return view('Ejalas::judicial-committee.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ejalas::judicial-committee.form')->with(compact('action'));
    }

    function edit(Request $request){
        $judicialCommittee = JudicialCommittee::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::judicial-committee.form')->with(compact('action','judicialCommittee'));
    }

}
