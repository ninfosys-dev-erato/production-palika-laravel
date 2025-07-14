<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\Target;

class TargetAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:targets view')->only('index');
        //$this->middleware('permission:targets edit')->only('edit');
        //$this->middleware('permission:targets create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::targets.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::targets.form')->with(compact('action'));
    }

    function edit(Request $request){
        $target = Target::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::targets.form')->with(compact('action','target'));
    }

}
