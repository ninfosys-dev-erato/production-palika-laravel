<?php

namespace Src\GrantManagement\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\GrantManagement\Models\Group;

class GroupAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:groups view')->only('index');
        //$this->middleware('permission:groups edit')->only('edit');
        //$this->middleware('permission:groups create')->only('create');
    }

    function index(Request $request)
    {
        return view('GrantManagement::groups.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('GrantManagement::groups.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $group = Group::find($request->route('id'));
        $action = Action::UPDATE;
        return view('GrantManagement::groups.form')->with(compact('action', 'group'));
    }

    function show(Request $request)
    {
        $group = Group::with(
            'province',
            'district',
            'localBody',
            'ward'
        )->find($request->route('id'));

        if (!$group) {
            $group = [];
        }

        return view('GrantManagement::groups.show')->with(compact('group'));
    }

    public function reports()
    {
        return view('GrantManagement::group-reports.form');
    }
}
