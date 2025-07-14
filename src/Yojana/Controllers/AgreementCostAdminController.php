<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\AgreementCost;

class AgreementCostAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:agreement_costs view')->only('index');
        //$this->middleware('permission:agreement_costs edit')->only('edit');
        //$this->middleware('permission:agreement_costs create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::agreement-costs.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::agreement-costs.form')->with(compact('action'));
    }

    function edit(Request $request){
        $agreementCost = AgreementCost::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::agreement-costs.form')->with(compact('action','agreementCost'));
    }

}
