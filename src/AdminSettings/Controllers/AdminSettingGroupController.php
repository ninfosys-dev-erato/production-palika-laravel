<?php

namespace Src\AdminSettings\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\AdminSettings\Models\AdminSettingGroup;

class AdminSettingGroupController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:group_access', only: ['index']),
            new Middleware('permission:group_create', only: ['create']),
            new Middleware('permission:group_update', only: ['edit']),
        ];
    }

    public function index()
    {
        return view('AdminSettings::group.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('AdminSettings::group.create')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $group = AdminSettingGroup::find($request->route('id'));
        $action = Action::UPDATE;
        return view('AdminSettings::group.create')->with(compact('action', 'group'));
    }
}
