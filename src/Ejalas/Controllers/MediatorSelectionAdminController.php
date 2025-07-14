<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\MediatorSelection;

class MediatorSelectionAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:mediator_selections view')->only('index');
        //$this->middleware('permission:mediator_selections edit')->only('edit');
        //$this->middleware('permission:mediator_selections create')->only('create');
    }

    function index(Request $request)
    {
        $from = ($request->from);
        return view('Ejalas::mediator-selection.index')->with(compact('from'));
    }

    function create(Request $request,  $from = null)
    {
        $action = Action::CREATE;
        return view('Ejalas::mediator-selection.form')->with(compact('action', 'from'));
    }

    function edit(Request $request,  $from = null)
    {
        $mediatorSelection = MediatorSelection::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::mediator-selection.form')->with(compact('action', 'mediatorSelection', 'from'));
    }
    function preview(Request $request)
    {
        $mediatorSelection = MediatorSelection::findOrFail($request->route('id'));
        return view('Ejalas::mediator-selection.preview', compact('mediatorSelection'));
    }
    function reconciliationIndex()
    {
        return view('Ejalas::mediator-selection.reconciliation-center.index');
    }
}
