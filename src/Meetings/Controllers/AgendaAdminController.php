<?php

namespace Src\Meetings\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Meetings\Models\Agenda;

class AgendaAdminController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:meeting_agenda_access', only: ['index']),
            new Middleware('permission:meeting_agenda_create', only: ['create']),
            new Middleware('permission:meeting_agenda_update', only: ['edit']),
        ];
    }
    function edit(Request $request)
    {
        $agenda = Agenda::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Meetings::agenda-form')->with(compact('action', 'agenda'));
    }
}