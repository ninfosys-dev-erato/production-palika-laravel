<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\JudicialEmployee;

class JudicialEmployeeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:judicial_employees view')->only('index');
        //$this->middleware('permission:judicial_employees edit')->only('edit');
        //$this->middleware('permission:judicial_employees create')->only('create');
    }

    function index(Request $request)
    {
        return view('Ejalas::judicial-employee.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ejalas::judicial-employee.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $judicialEmployee = JudicialEmployee::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::judicial-employee.form')->with(compact('action', 'judicialEmployee'));
    }
}
