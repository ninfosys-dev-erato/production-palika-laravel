<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\Mediator;

class MediatorAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:mediators view')->only('index');
        //$this->middleware('permission:mediators edit')->only('edit');
        //$this->middleware('permission:mediators create')->only('create');
    }

    function index(Request $request)
    {
        return view('Ejalas::mediator.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ejalas::mediator.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $mediator = Mediator::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::mediator.form')->with(compact('action', 'mediator'));
    }
}
