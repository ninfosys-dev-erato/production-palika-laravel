<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\ReconciliationCenter;

class ReconciliationCenterAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:reconciliation_centers view')->only('index');
        //$this->middleware('permission:reconciliation_centers edit')->only('edit');
        //$this->middleware('permission:reconciliation_centers create')->only('create');
    }

    function index(Request $request)
    {
        return view('Ejalas::reconcilation-center.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ejalas::reconcilation-center.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $reconciliationCenter = ReconciliationCenter::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::reconcilation-center.form')->with(compact('action', 'reconciliationCenter'));
    }
}
