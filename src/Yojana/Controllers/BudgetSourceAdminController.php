<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\BudgetSource;

class BudgetSourceAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:budget_sources view')->only('index');
        //$this->middleware('permission:budget_sources edit')->only('edit');
        //$this->middleware('permission:budget_sources create')->only('create');
    }

    function index(Request $request)
    {
        return view('Yojana::budget-sources.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::budget-sources.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $budgetSource = BudgetSource::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::budget-sources.form')->with(compact('action', 'budgetSource'));
    }
}
