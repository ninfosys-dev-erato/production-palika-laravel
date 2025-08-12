<?php

namespace Src\Beruju\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Beruju\Models\BerujuEntry;

class BerujuEntryAdminController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:beruju access', only: ['index']),
            new Middleware('permission:beruju create', only: ['create']),
            new Middleware('permission:beruju edit', only: ['edit']),
            new Middleware('permission:beruju view', only: ['view', 'preview']),
        ];
    }

    public function index(Request $request)
    {
        return view('Beruju::beruju-entry.index');
    }

    public function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Beruju::beruju-entry.form')->with(compact('action'));
    }

    public function edit(Request $request)
    {
        $berujuEntry = BerujuEntry::findOrFail($request->route('id'));
        $action = Action::UPDATE;
        return view('Beruju::beruju-entry.form')->with(compact('action', 'berujuEntry'));
    }
}
