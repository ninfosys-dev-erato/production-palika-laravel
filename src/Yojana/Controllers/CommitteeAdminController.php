<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Yojana\Models\Committee;

class CommitteeAdminController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:committee_access', only: ['index']),
            new Middleware('permission:committee_create', only: ['create']),
            new Middleware('permission:committee_update', only: ['edit']),
        ];
    }
    function index(Request $request)
    {
        return view(view: 'Yojana::committees.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::committees.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $committee = Committee::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::committees.form')->with(compact('action', 'committee'));
    }
}
