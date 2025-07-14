<?php

namespace Src\Meetings\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Meetings\Models\Decision;

class DecisionAdminController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:meeting_decision_access', only: ['index']),
            new Middleware('permission:meeting_decision_create', only: ['create']),
            new Middleware('permission:meeting_decision_update', only: ['edit'])
        ];
    }
    function index()
    {
        $meetingId = (int)request('meeting');

        return view('Decisions::index')->with(compact('meetingId'));
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Decisions::form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $decision = Decision::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Meetings::decision-form')->with(compact('action', 'decision'));
    }
}