<?php

namespace Src\TaskTracking\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Src\TaskTracking\Models\Anusuchi;
use Src\TaskTracking\Models\EmployeeMarking;
use Src\TaskTracking\Service\ReportAdminService;

class AnusuchiAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:anusuchis view')->only('index');
        //$this->middleware('permission:anusuchis edit')->only('edit');
        //$this->middleware('permission:anusuchis create')->only('create');
    }

    function index(Request $request)
    {
        return view('TaskTracking::anusuchi.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('TaskTracking::anusuchi.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $anusuchi = Anusuchi::find($request->route('id'));
        $action = Action::UPDATE;
        return view('TaskTracking::anusuchi.form')->with(compact('action', 'anusuchi'));
    }
    function template(Request $request)
    {
        return view('TaskTracking::anusuchi.anusuchi-table');
    }
    function report(Request $request): View
    {
        return view('TaskTracking::report-anusuchi.report-index');
    }
    function addReport()
    {
        $action = Action::CREATE;
        return view('TaskTracking::report-anusuchi.report-anusuchi-form')->with(compact('action'));
    }
    function editReport(Request $request)
    {
        $employeeMarkingId = $request->route('id');
        $action = Action::UPDATE;
        return view('TaskTracking::report-anusuchi.report-anusuchi-form')->with(compact('action', 'employeeMarkingId'));
    }
    function viewReport(Request $request)
    {
        $employeeMarkingId = $request->route('id');
        return view('TaskTracking::report-anusuchi.anusuchi-report-view')->with(compact('employeeMarkingId'));
    }
    function printReport(Request $request)
    {
        $service = new ReportAdminService;
        $employeeMarkingId = $request->route('id');
        $employeeMarking = EmployeeMarking::with([
            'anusuchi',
            'employee',
            'anusuchi.criterion',
            'employeeMarkingScore',
            'employeeMarkingScore.employee',
            'employeeMarkingScore.employee.branch',
            'employeeMarkingScore.employee.designation'
        ])->findOrFail($employeeMarkingId);
        $groupedScores = $employeeMarking->employeeMarkingScore->groupBy('employee_id')->all();
        $html =  view('TaskTracking::report-anusuchi.anusuchi-report-pdf')->with(compact('employeeMarking', 'groupedScores'));
        return $service->getReport($html);
    }
}
