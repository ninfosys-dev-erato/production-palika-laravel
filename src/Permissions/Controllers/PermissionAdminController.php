<?php

namespace Src\Permissions\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Permissions\Models\Permission;

class PermissionAdminController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:permissions_access', only: ['index']),
            new Middleware('permission:permissions_create', only: ['create']),
            new Middleware('permission:permissions_update', only: ['edit']),
        ];
    }

    function index(Request $request)
    {
        return view('Permissions::index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Permissions::form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $permission = Permission::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Permissions::form')->with(compact('action', 'permission'));
    }
}
