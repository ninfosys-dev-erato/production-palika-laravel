<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\SettlementDetail;

class SettlementDetailAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:case_records view')->only('index');
        //$this->middleware('permission:case_records edit')->only('edit');
        //$this->middleware('permission:case_records create')->only('create');
    }

    function index(Request $request)
    {
        return view('Ejalas::settlement-detail.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ejalas::settlement-detail.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $settlementDetail = SettlementDetail::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::settlement-detail.form')->with(compact('action', 'settlementDetail'));
    }
}
