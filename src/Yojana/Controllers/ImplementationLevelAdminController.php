<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ImplementationLevel;

class ImplementationLevelAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:implementation_levels view')->only('index');
        //$this->middleware('permission:implementation_levels edit')->only('edit');
        //$this->middleware('permission:implementation_levels create')->only('create');
    }

    function index(Request $request)
    {
        return view('Yojana::implementation-levels.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::implementation-levels.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $implementationLevel = ImplementationLevel::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::implementation-levels.form')->with(compact('action', 'implementationLevel'));
    }
}
