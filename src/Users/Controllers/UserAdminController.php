<?php

namespace Src\Users\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserAdminController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:users_access', only: ['index']),
            new Middleware('permission:users_create', only: ['create']),
            new Middleware('permission:users_edit', only: ['edit']),
            new Middleware('permission:users_manage', only: ['manage', 'roles', 'permission'])
        ];
    }

    function index(Request $request)
    {
        return view('Users::index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        $selectedward = $request->query('selectedward') ?? null;
        return view('Users::form')->with(compact('action', 'selectedward'));
    }

    function edit(Request $request)
    {
        $user = User::find($request->route('id'));
        $action = Action::UPDATE;
        $selectedward = $request->query('selectedward') ?? null;
        return view('Users::form')->with(compact('action', 'user', 'selectedward'));
    }

    function roles(Request $request)
    {
        $user = User::find($request->route('id'));
        return view('Users::roles')->with(compact('user'));
    }

    function permissions(Request $request)
    {
        $user = User::find($request->route('id'));
        return view('Users::permissions')->with(compact('user'));
    }

    public function manage(Request $request)
    {
        $user = User::find($request->route('id'));

        if (!$user) {
            return redirect()->route('admin.users.index')->with('error', 'User not found.');
        }
        $action = Action::CREATE;
        return view('Users::manage', compact(['user', 'action']));
    }
}
