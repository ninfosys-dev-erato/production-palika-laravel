<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\PlanLevel;

class PlanLevelAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:plan_levels view')->only('index');
        //$this->middleware('permission:plan_levels edit')->only('edit');
        //$this->middleware('permission:plan_levels create')->only('create');
    }

    function index(Request $request)
    {
        return view('Yojana::plan-levels.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::plan-levels.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $planLevel = PlanLevel::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::plan-levels.form')->with(compact('action', 'planLevel'));
    }
}
