<?php

namespace Src\ActivityLogs\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;
use Src\ActivityLogs\Models\ActivityLog;

class ActivityLogAdminController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:activity_logs access', only: ['index']),
            new Middleware('permission:activity_logs create', only: ['create']),
            new Middleware('permission:activity_logs view', only: ['show'])
        ];
    }

    function index(Request $request): View
    {
        return view('ActivityLogs::index');
    }

    function create(Request $request): View
    {
        $action = Action::CREATE;
        return view('ActivityLogs::form')->with(compact('action'));
    }

    function edit(Request $request): View
    {
        $activityLog = ActivityLog::find($request->route('id'));
        $action = Action::UPDATE;
        return view('ActivityLogs::form')->with(compact('action', 'activityLog'));
    }

    function show(Request $request): View
    {
        $log = ActivityLog::findOrFail($request['id']);

        $causer_instance = null;
        try {
            if (class_exists($log->causer_type)) {
                $causer_instance = ($log->causer_type)::find($log->causer_id);
            }
        } catch (\Exception $e) {
            $causer_instance = null;
        }

        $properties = json_decode($log->properties, true);

        return view('ActivityLogs::show', compact('log', 'causer_instance', 'properties'));
    }
}
