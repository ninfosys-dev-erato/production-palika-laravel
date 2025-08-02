<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Yojana\Models\CommitteeType;

class CommitteeTypeAdminController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            // new Middleware('permission:committee_type_access', only: ['index']),
            // new Middleware('permission:committee_type_create', only: ['create']),
            // new Middleware('permission:committee_type_update', only: ['edit']),
        ];
    }

    function index(Request $request)
    {
        return view('Yojana::committee-types.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::committee-types.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $committeeType = CommitteeType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::committee-types.form')->with(compact('action', 'committeeType'));
    }
}
