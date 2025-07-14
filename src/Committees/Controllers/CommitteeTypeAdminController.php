<?php

namespace Src\Committees\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Committees\Models\CommitteeType;

class CommitteeTypeAdminController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:committee_type_access', only: ['index']),
            new Middleware('permission:committee_type_create', only: ['create']),
            new Middleware('permission:committee_type_update', only: ['edit']),
        ];
    }

    function index(Request $request)
    {
        return view('Committees::committee-type-index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Committees::committee-type-form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $committeeType = CommitteeType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Committees::committee-type-form')->with(compact('action', 'committeeType'));
    }
}
