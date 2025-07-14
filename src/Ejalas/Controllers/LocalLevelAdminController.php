<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\LocalLevel;

class LocalLevelAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:local_levels view')->only('index');
        //$this->middleware('permission:local_levels edit')->only('edit');
        //$this->middleware('permission:local_levels create')->only('create');
    }

    function index(Request $request){
        return view('Ejalas::local-level.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ejalas::local-level.form')->with(compact('action'));
    }

    function edit(Request $request){
        $localLevel = LocalLevel::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::local-level.form')->with(compact('action','localLevel'));
    }

}
