<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\FulfilledCondition;

class FulfilledConditionAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:fulfilled_conditions view')->only('index');
        //$this->middleware('permission:fulfilled_conditions edit')->only('edit');
        //$this->middleware('permission:fulfilled_conditions create')->only('create');
    }

    function index(Request $request)
    {
        $from = $request->from;
        return view('Ejalas::fulfilled-condition.index')->with(compact('from'));
    }

    function create(Request $request, $from = null)
    {
        $action = Action::CREATE;
        return view('Ejalas::fulfilled-condition.form')->with(compact('action', 'from'));
    }

    function edit(Request $request, $from)
    {
        $fulfilledCondition = FulfilledCondition::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::fulfilled-condition.form')->with(compact('action', 'fulfilledCondition', 'from'));
    }
    function preview(Request $request)
    {
        $fulfilledCondition = FulfilledCondition::find($request->route('id'));
        return view('Ejalas::fulfilled-condition.preview', compact('fulfilledCondition'));
    }
    function report(Request $request)
    {
        return view('Ejalas::fulfilled-condition.report');
    }
    function reconciliationIndex()
    {
        return view('Ejalas::fulfilled-condition.reconciliation-center.index');
    }
}
