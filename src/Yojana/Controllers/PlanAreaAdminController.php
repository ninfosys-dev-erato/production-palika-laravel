<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\PlanArea;

class PlanAreaAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:plan_areas view')->only('index');
        //$this->middleware('permission:plan_areas edit')->only('edit');
        //$this->middleware('permission:plan_areas create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::plan-areas.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::plan-areas.form')->with(compact('action'));
    }

    function edit(Request $request){
        $planArea = PlanArea::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::plan-areas.form')->with(compact('action','planArea'));
    }

}
