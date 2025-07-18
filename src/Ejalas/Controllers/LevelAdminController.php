<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\Level;

class LevelAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:levels view')->only('index');
        //$this->middleware('permission:levels edit')->only('edit');
        //$this->middleware('permission:levels create')->only('create');
    }

    function index(Request $request){
        return view('Ejalas::level.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ejalas::level.form')->with(compact('action'));
    }

    function edit(Request $request){
        $level = Level::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::level.form')->with(compact('action','level'));
    }

}
