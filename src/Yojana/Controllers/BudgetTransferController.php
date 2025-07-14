<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\BudgetTransfer;

class BudgetTransferController extends Controller
{
    public function index()
    {
        return view('Yojana::budget-transfer.index');
    }

    public function create()
    {
        $action = Action::CREATE;
        return view('Yojana::budget-transfer.form', compact('action'));
    }

    function edit(Request $request)
    {
        $budgetTransfer = BudgetTransfer::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::budget-transfer.form')->with(compact('action', 'budgetTransfer'));
    }


}
