<?php

namespace Src\TaskTracking\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\TaskTracking\Models\Project;

class ProjectAdminController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            // new Middleware('permission:project_access', only: ['index']),
            // new Middleware('permission:project_create', only: ['create']),
            // new Middleware('permission:project_update', only: ['edit']),
        ];
    }

    function index(Request $request)
    {
        return view('TaskTracking::project-index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('TaskTracking::project-form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $project = Project::find($request->route('id'));
        $action = Action::UPDATE;
        return view('TaskTracking::project-form')->with(compact('action', 'project'));
    }
}
