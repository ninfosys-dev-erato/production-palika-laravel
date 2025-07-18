<?php

namespace Src\Roles\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Roles\Models\Role;

class RoleAdminController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:roles_access', only: ['index']),
            new Middleware('permission:roles_create', only: ['create']),
            new Middleware('permission:roles_update', only: ['edit']),
            new Middleware('permission:roles_manage', only: ['managePermissions'])
        ];
    }

    function index(Request $request){
        return view('Roles::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Roles::form')->with(compact('action'));
    }

    function edit(Request $request){
        $role = Role::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Roles::form')->with(compact('action','role'));
    }

    function managePermissions(Request $request){
        return view('Roles::manage');
    }

}
