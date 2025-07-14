<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\WitnessesRepresentative;

class WitnessesRepresentativeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:witnesses_representatives view')->only('index');
        //$this->middleware('permission:witnesses_representatives edit')->only('edit');
        //$this->middleware('permission:witnesses_representatives create')->only('create');
    }

    function index(Request $request)
    {
        return view('Ejalas::witnesses-representative.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ejalas::witnesses-representative.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $witnessesRepresentative = WitnessesRepresentative::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::witnesses-representative.form')->with(compact('action', 'witnessesRepresentative'));
    }
    function preview(Request $request)
    {
        $witnessesRepresentative = WitnessesRepresentative::find($request->route('id'));
        return view('Ejalas::witnesses-representative.preview', compact('witnessesRepresentative'));
    }
}
