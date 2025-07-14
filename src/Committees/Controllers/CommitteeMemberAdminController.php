<?php

namespace Src\Committees\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Committees\Models\CommitteeMember;

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
        return view('Committees::committee-member-index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Committees::committee-member-form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $committeeMember = CommitteeMember::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Committees::committee-member-form')->with(compact('action', 'committeeMember'));
    }
}
