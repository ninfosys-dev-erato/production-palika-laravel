<?php

namespace Src\TaskTracking\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\TaskTracking\Models\TaskType;

class TaskTypeAdminController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            // new Middleware('permission:task_type_access', only: ['index']),
            // new Middleware('permission:task_type_create', only: ['create']),
            // new Middleware('permission:task_type_update', only: ['edit']),
        ];
    }

    function index(Request $request)
    {
        return view('TaskTracking::task-type-index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('TaskTracking::task-type-form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $taskType = TaskType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('TaskTracking::task-type-form')->with(compact('action', 'taskType'));
    }
}
