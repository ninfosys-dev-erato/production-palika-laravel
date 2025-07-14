<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\PlanExtensionRecord;

class PlanExtensionRecordAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:plan_extension_records view')->only('index');
        //$this->middleware('permission:plan_extension_records edit')->only('edit');
        //$this->middleware('permission:plan_extension_records create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::plan-extension-records.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::plan-extension-records.form')->with(compact('action'));
    }

    function edit(Request $request){
        $planExtensionRecord = PlanExtensionRecord::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::plan-extension-records.form')->with(compact('action','planExtensionRecord'));
    }

}
