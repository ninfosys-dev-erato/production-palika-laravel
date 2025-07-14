<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\EvaluationCostDetail;

class EvaluationCostDetailAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:evaluation_cost_details view')->only('index');
        //$this->middleware('permission:evaluation_cost_details edit')->only('edit');
        //$this->middleware('permission:evaluation_cost_details create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::evaluation-cost-details.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::evaluation-cost-details.form')->with(compact('action'));
    }

    function edit(Request $request){
        $evaluationCostDetail = EvaluationCostDetail::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::evaluation-cost-details.form')->with(compact('action','evaluationCostDetail'));
    }

}
