<?php

namespace Src\TaskTracking\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\TaskTracking\Models\EmployeeMarking;

class EmployeeMarkingAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:employee_markings view')->only('index');
        //$this->middleware('permission:employee_markings edit')->only('edit');
        //$this->middleware('permission:employee_markings create')->only('create');
    }

    function index(Request $request){
        return view('TaskTracking::employee-marking.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('TaskTracking::employee-marking.form')->with(compact('action'));
    }

    function edit(Request $request){
        $employeeMarking = EmployeeMarking::find($request->route('id'));
        $action = Action::UPDATE;
        return view('TaskTracking::employee-marking.form')->with(compact('action','employeeMarking'));
    }

}
