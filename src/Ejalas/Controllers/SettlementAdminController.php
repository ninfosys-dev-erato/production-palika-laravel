<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\Settlement;

class SettlementAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:settlements view')->only('index');
        //$this->middleware('permission:settlements edit')->only('edit');
        //$this->middleware('permission:settlements create')->only('create');
    }

    function index(Request $request)
    {
        $from = $request->from;
        return view('Ejalas::settlement.index')->with(compact('from'));
    }

    function create(Request $request, $from = null)
    {
        $action = Action::CREATE;
        return view('Ejalas::settlement.form')->with(compact('action', 'from'));
    }

    function edit(Request $request, $from)
    {
        $settlement = Settlement::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::settlement.form')->with(compact('action', 'settlement', 'from'));
    }
    function preview(Request $request)
    {
        $settlement = Settlement::find($request->route('id'));
        return view('Ejalas::settlement.preview', compact('settlement'));
    }
    function report()
    {
        return view('Ejalas::settlement.report');
    }
    function reconciliationIndex()
    {
        return view('Ejalas::settlement.reconciliation-center.index');
    }
}
