<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\JudicialMember;

class JudicialMemberAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:judicial_members view')->only('index');
        //$this->middleware('permission:judicial_members edit')->only('edit');
        //$this->middleware('permission:judicial_members create')->only('create');
    }

    function index(Request $request){
        return view('Ejalas::judicial-member.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ejalas::judicial-member.form')->with(compact('action'));
    }

    function edit(Request $request){
        $judicialMember = JudicialMember::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::judicial-member.form')->with(compact('action','judicialMember'));
    }

}
