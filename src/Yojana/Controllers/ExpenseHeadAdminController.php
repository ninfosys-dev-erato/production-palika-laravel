<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ExpenseHead;

class ExpenseHeadAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:expense_heads view')->only('index');
        //$this->middleware('permission:expense_heads edit')->only('edit');
        //$this->middleware('permission:expense_heads create')->only('create');
    }

    function index(Request $request)
    {
        return view('Yojana::expense-heads.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::expense-heads.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $expenseHead = ExpenseHead::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::expense-heads.form')->with(compact('action', 'expenseHead'));
    }
}
