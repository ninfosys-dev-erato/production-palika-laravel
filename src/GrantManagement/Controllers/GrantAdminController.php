<?php

namespace Src\GrantManagement\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\GrantManagement\Models\Grant;

class GrantAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:grants view')->only('index');
        //$this->middleware('permission:grants edit')->only('edit');
        //$this->middleware('permission:grants create')->only('create');
    }

    function index(Request $request){
        return view('GrantManagement::grants.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('GrantManagement::grants.form')->with(compact('action'));
    }

    function edit(Request $request){
        $grant = Grant::find($request->route('id'));
        $action = Action::UPDATE;
        return view('GrantManagement::grants.form')->with(compact('action','grant'));
    }

}
