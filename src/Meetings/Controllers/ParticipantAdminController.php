<?php

namespace Src\Meetings\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Meetings\Models\Participant;

class ParticipantAdminController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:meeting_participants_access', only: ['index']),
            new Middleware('permission:meeting_participants_create', only: ['create']),
            new Middleware('permission:meeting_participants_update', only: ['edit']),
        ];
    }

    function edit(Request $request)
    {
        $participant = Participant::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Meetings::participant-form')->with(compact('action', 'participant'));
    }
}