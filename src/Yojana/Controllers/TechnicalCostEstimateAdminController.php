<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\TechnicalCostEstimate;

class TechnicalCostEstimateAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:technical_cost_estimates view')->only('index');
        //$this->middleware('permission:technical_cost_estimates edit')->only('edit');
        //$this->middleware('permission:technical_cost_estimates create')->only('create');
    }

    function index(Request $request){
        return view('TechnicalCostEstimates::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('TechnicalCostEstimates::form')->with(compact('action'));
    }

    function edit(Request $request){
        $technicalCostEstimate = TechnicalCostEstimate::find($request->route('id'));
        $action = Action::UPDATE;
        return view('TechnicalCostEstimates::form')->with(compact('action','technicalCostEstimate'));
    }

}
