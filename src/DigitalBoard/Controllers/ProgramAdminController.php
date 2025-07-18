<?php

namespace Src\DigitalBoard\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\DigitalBoard\Models\Program;

class ProgramAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:programs view')->only('index');
        //$this->middleware('permission:programs edit')->only('edit');
        //$this->middleware('permission:programs create')->only('create');
    }

    function index(Request $request)
    {
        return view('DigitalBoard::programs.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('DigitalBoard::programs.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $program = Program::find($request->route('id'));
        $action = Action::UPDATE;
        return view('DigitalBoard::programs.form')->with(compact('action', 'program'));
    }
}
