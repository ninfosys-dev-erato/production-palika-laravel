<?php

namespace Src\Beruju\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Beruju\Models\Action as BerujuAction;

class ActionAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:actions view')->only('index');
        //$this->middleware('permission:actions edit')->only('edit');
        //$this->middleware('permission:actions create')->only('create');
    }

    function index(Request $request)
    {
        return view('Beruju::actions.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Beruju::actions.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $berujuAction = BerujuAction::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Beruju::actions.form')->with(compact('action', 'berujuAction'));
    }

    function show(Request $request)
    {
        $berujuAction = BerujuAction::with(['resolutionCycle', 'actionType', 'performedBy', 'creator', 'updater'])
            ->findOrFail($request->route('id'));
        return view('Beruju::actions.show')->with(compact('berujuAction'));
    }
}
