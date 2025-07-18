<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\Evaluation;
use Src\Yojana\Models\Plan;

class EvaluationAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:evaluations view')->only('index');
        //$this->middleware('permission:evaluations edit')->only('edit');
        //$this->middleware('permission:evaluations create')->only('create');
    }

    function index(Request $request)
    {
        return view('Yojana::evaluations.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::evaluations.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $evaluation = Evaluation::find($request->route('id'));
        $plan = Plan::find($request->route('planId'));
        $action = Action::UPDATE;
        return view('Yojana::evaluations.form')->with(compact('action', 'evaluation', 'plan'));
    }
}
