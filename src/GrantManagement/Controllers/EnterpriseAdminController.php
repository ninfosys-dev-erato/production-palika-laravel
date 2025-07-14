<?php

namespace Src\GrantManagement\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\GrantManagement\Models\Enterprise;

class EnterpriseAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:enterprises view')->only('index');
        //$this->middleware('permission:enterprises edit')->only('edit');
        //$this->middleware('permission:enterprises create')->only('create');
    }

    function index(Request $request)
    {
        return view('GrantManagement::enterprises.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('GrantManagement::enterprises.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $enterprise = Enterprise::find($request->route('id'));
        $action = Action::UPDATE;
        return view('GrantManagement::enterprises.form')->with(compact('action', 'enterprise'));
    }

    function show(Request $request)
    {
        $enterprise = Enterprise::with(['province', 'district', 'localBody', 'enterprise_type'])
            ->find($request->route('id')) ?? [];

        return view('GrantManagement::enterprises.show', compact('enterprise'));
    }

    public function reports()
    {
        return view('GrantManagement::enterprise-reports.form');
    }

}
