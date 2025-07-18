<?php

namespace Src\TaskTracking\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\TaskTracking\Models\EmployeeMarkingScore;

class EmployeeMarkingScoreAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:employee_marking_scores view')->only('index');
        //$this->middleware('permission:employee_marking_scores edit')->only('edit');
        //$this->middleware('permission:employee_marking_scores create')->only('create');
    }

    function index(Request $request){
        return view('TaskTracking::employee-marking-score.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('TaskTracking::employee-marking-score.form')->with(compact('action'));
    }

    function edit(Request $request){
        $employeeMarkingScore = EmployeeMarkingScore::find($request->route('id'));
        $action = Action::UPDATE;
        return view('TaskTracking::employee-marking-score.form')->with(compact('action','employeeMarkingScore'));
    }

}
