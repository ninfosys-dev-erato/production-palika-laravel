<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Yojana\Models\CommitteeMember;

class CommitteeMemberAdminController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:committee_member_access', only: ['index']),
            new Middleware('permission:committee_member_create', only: ['create']),
            new Middleware('permission:committee_member_edit', only: ['update']),
        ];
    }

    function index(Request $request)
    {
        return view('Yojana::consumer-committee-members.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::consumer-committee-members.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $committeeMember = CommitteeMember::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Committees::consumer-committee-members.form')->with(compact('action', 'committeeMember'));
    }
}
