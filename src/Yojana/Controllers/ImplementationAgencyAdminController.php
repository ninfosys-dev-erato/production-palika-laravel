<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ImplementationAgency;

class ImplementationAgencyAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:implementation_agencies view')->only('index');
        //$this->middleware('permission:implementation_agencies edit')->only('edit');
        //$this->middleware('permission:implementation_agencies create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::implementation-agencies.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::implementation-agencies.form')->with(compact('action'));
    }

    function edit(Request $request){
        $implementationAgency = ImplementationAgency::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::implementation-agencies.form')->with(compact('action','implementationAgency'));
    }

}
