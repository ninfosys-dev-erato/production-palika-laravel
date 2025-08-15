<?php

namespace Src\Beruju\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Beruju\Models\ResolutionCycle;

class ResolutionCycleAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:resolution-cycles view')->only('index');
        //$this->middleware('permission:resolution-cycles edit')->only('edit');
        //$this->middleware('permission:resolution-cycles create')->only('create');
    }

    function index(Request $request)
    {
        return view('Beruju::resolution-cycles.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Beruju::resolution-cycles.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $resolutionCycle = ResolutionCycle::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Beruju::resolution-cycles.form')->with(compact('action', 'resolutionCycle'));
    }

    function show(Request $request)
    {
        $resolutionCycle = ResolutionCycle::with(['berujuEntry', 'incharge', 'assignedBy', 'creator', 'updater'])
            ->findOrFail($request->route('id'));
        return view('Beruju::resolution-cycles.show')->with(compact('resolutionCycle'));
    }
}
