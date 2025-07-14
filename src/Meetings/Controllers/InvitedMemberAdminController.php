<?php

namespace Src\Meetings\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Meetings\Models\InvitedMember;

class InvitedMemberAdminController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:meeting_invited_member_access', only: ['index']),
            new Middleware('permission:meeting_invited_member_create', only: ['create']),
            new Middleware('permission:meeting_invited_member_update', only: ['edit']),

        ];
    }


    function edit(Request $request)
    {
        $invitedMember = InvitedMember::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Meetings::invitedMember-form')->with(compact('action', 'invitedMember'));
    }
}