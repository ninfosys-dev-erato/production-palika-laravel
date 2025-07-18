<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\Organization;

class OrganizationAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:organizations view')->only('index');
        //$this->middleware('permission:organizations edit')->only('edit');
        //$this->middleware('permission:organizations create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::organizations.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::organizations.form')->with(compact('action'));
    }

    function edit(Request $request){
        $organization = Organization::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::organizations.form')->with(compact('action','organization'));
    }

}
