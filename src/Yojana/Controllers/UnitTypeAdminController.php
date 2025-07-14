<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\UnitType;

class UnitTypeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:unit_types view')->only('index');
        //$this->middleware('permission:unit_types edit')->only('edit');
        //$this->middleware('permission:unit_types create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::unit-types.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::unit-types.form')->with(compact('action'));
    }

    function edit(Request $request){
        $unitType = UnitType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::unit-types.form')->with(compact('action','unitType'));
    }

}
