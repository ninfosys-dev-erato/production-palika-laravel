<?php

namespace Src\Beruju\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Beruju\Models\ActionType;

class ActionTypeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:action-types view')->only('index');
        //$this->middleware('permission:action-types edit')->only('edit');
        //$this->middleware('permission:action-types create')->only('create');
    }

    function index(Request $request)
    {
        return view('Beruju::action-types.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Beruju::action-types.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $actionType = ActionType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Beruju::action-types.form')->with(compact('action', 'actionType'));
    }

    function show(Request $request)
    {
        $actionType = ActionType::with(['subCategory', 'creator', 'updater'])->findOrFail($request->route('id'));
        return view('Beruju::action-types.show')->with(compact('actionType'));
    }
}
