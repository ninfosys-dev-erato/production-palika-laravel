<?php

namespace Src\Employees\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Employees\Models\Designation;

class DesignationController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:designation access', only: ['index']),
            new Middleware('permission:designation create', only: ['create']),
            new Middleware('permission:designation edit', only: ['edit']),
        ];
    }

    function index(Request $request)
    {
        return view('Employees::designation.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Employees::designation.create')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $designation = Designation::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Employees::designation.create')->with(compact('action', 'designation'));
    }
}
