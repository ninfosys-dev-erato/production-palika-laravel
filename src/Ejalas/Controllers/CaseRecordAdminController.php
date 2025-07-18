<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\CaseRecord;

class CaseRecordAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:case_records view')->only('index');
        //$this->middleware('permission:case_records edit')->only('edit');
        //$this->middleware('permission:case_records create')->only('create');
    }

    function index(Request $request)
    {
        return view('Ejalas::case-record.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ejalas::case-record.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $caseRecord = CaseRecord::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::case-record.form')->with(compact('action', 'caseRecord'));
    }
    function preview(Request $request)
    {
        $caseRecord = CaseRecord::find($request->route('id'));
        return view('Ejalas::case-record.preview', compact('caseRecord'));
    }
    function report(Request $request)
    {
        return view('Ejalas::case-record.report');
    }
}
