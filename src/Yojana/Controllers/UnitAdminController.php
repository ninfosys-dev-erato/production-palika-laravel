<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\Unit;

class UnitAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:units view')->only('index');
        //$this->middleware('permission:units edit')->only('edit');
        //$this->middleware('permission:units create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::units.index');
    }

    function create(Request $request){

        $action = Action::CREATE;
        return view('Yojana::units.form')->with(compact('action'));
    }

    function edit(Request $request){
        $unit = Unit::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::units.form')->with(compact('action','unit'));
    }

}
