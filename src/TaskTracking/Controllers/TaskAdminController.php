<?php

namespace Src\TaskTracking\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\TaskTracking\Models\Task;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TaskAdminController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        // return [
        //     new Middleware('permission:task_access', only: ['index']),
        //     new Middleware('permission:task_create', only: ['create']),
        //     new Middleware('permission:task_update', only: ['edit']),
        //     new Middleware('permission:task_view', only: ['view']),
        // ];
    }

    function index(Request $request)
    {
        $action = Action::CREATE;
        return view('TaskTracking::task-index')->with(compact('action'));
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('TaskTracking::task-form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $task = Task::find($request->route('id'));
        $action = Action::UPDATE;
        return view('TaskTracking::task-form')->with(compact('action', 'task'));
    }
    function view(Request $request)
    {
        $task = Task::with('project', 'taskType', 'comments.commenter',  'comments.attachments', 'taskActivities.user', 'attachments')->find($request->route('id'));
        return view('TaskTracking::task-show')->with(compact('task'));
    }
}
