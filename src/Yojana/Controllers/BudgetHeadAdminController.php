<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\BudgetHead;

class BudgetHeadAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:budget_heads view')->only('index');
        //$this->middleware('permission:budget_heads edit')->only('edit');
        //$this->middleware('permission:budget_heads create')->only('create');
    }

    function index(Request $request)
    {
        return view('Yojana::budget-heads.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::budget-heads.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $budgetHead = BudgetHead::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::budget-heads.form')->with(compact('action', 'budgetHead'));
    }
}
