<?php

namespace Src\DigitalBoard\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\DigitalBoard\Models\CitizenCharter;

class CitizenCharterAdminController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:citizencharter_access', only: ['index']),
            new Middleware('permission:citizencharter_create', only: ['create']),
            new Middleware('permission:citizencharter_edit', only: ['edit']),
        ];
    }

    function index(Request $request)
    {
        return view('DigitalBoard::citizen-charter.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('DigitalBoard::citizen-charter.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $citizenCharter = CitizenCharter::find($request->route('id'));
        $action = Action::UPDATE;
        return view('DigitalBoard::citizen-charter.form')->with(compact('action', 'citizenCharter'));
    }
}
