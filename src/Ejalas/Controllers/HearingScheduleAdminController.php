<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\HearingSchedule;

class HearingScheduleAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:hearing_schedules view')->only('index');
        //$this->middleware('permission:hearing_schedules edit')->only('edit');
        //$this->middleware('permission:hearing_schedules create')->only('create');
    }

    function index(Request $request)
    {
        $from = $request->from;
        return view('Ejalas::hearing-schedule.index')->with(compact('from'));
    }

    function create(Request $request, $from = null)
    {
        $action = Action::CREATE;
        return view('Ejalas::hearing-schedule.form')->with(compact('action', 'from'));
    }

    function edit(Request $request, $from)
    {
        $hearingSchedule = HearingSchedule::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::hearing-schedule.form')->with(compact('action', 'hearingSchedule', 'from'));
    }
    function preview(Request $request)
    {
        $hearingSchedule = HearingSchedule::with([
            'complaintRegistration.disputeMatter.disputeArea',
            'complaintRegistration.priority',
            'complaintRegistration.fiscalYear',
            'complaintRegistration.parties.permanentDistrict',
            'complaintRegistration.parties.permanentLocalBody',
            'complaintRegistration.parties.temporaryDistrict',
            'complaintRegistration.parties.temporaryLocalBody'
        ])->findOrFail($request->route('id'));


        return view('Ejalas::hearing-schedule.preview', compact('hearingSchedule'));
    }
    function report()
    {
        return view('Ejalas::hearing-schedule.report');
    }
    function reconciliationIndex()
    {
        return view('Ejalas::hearing-schedule.reconciliation-center.index');
    }
}
