<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\BudgetDetail;

class BudgetDetailAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:budget_details view')->only('index');
        //$this->middleware('permission:budget_details edit')->only('edit');
        //$this->middleware('permission:budget_details create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::budget-details.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::budget-details.form')->with(compact('action'));
    }

    function edit(Request $request){
        $budgetDetail = BudgetDetail::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::budget-details.form')->with(compact('action','budgetDetail'));
    }

}
