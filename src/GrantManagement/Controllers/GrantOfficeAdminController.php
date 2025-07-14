<?php

namespace Src\GrantManagement\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\GrantManagement\Models\GrantOffice;

class GrantOfficeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:grant_offices view')->only('index');
        //$this->middleware('permission:grant_offices edit')->only('edit');
        //$this->middleware('permission:grant_offices create')->only('create');
    }

    function index(Request $request){
        return view('GrantManagement::grant-offices.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('GrantManagement::grant-offices.form')->with(compact('action'));
    }

    function edit(Request $request){
        $grantOffice = GrantOffice::find($request->route('id'));
        $action = Action::UPDATE;
        return view('GrantManagement::grant-offices.form')->with(compact('action','grantOffice'));
    }

}
