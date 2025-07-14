<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\DisputeDeadline;

class DisputeDeadlineAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:dispute_deadlines view')->only('index');
        //$this->middleware('permission:dispute_deadlines edit')->only('edit');
        //$this->middleware('permission:dispute_deadlines create')->only('create');
    }

    function index(Request $request)
    {
        return view('Ejalas::dispute-deadline.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ejalas::dispute-deadline.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $disputeDeadline = DisputeDeadline::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::dispute-deadline.form')->with(compact('action', 'disputeDeadline'));
    }
    function preview(Request $request)
    {
        $disputeDeadline = DisputeDeadline::with([
            'complaintRegistration.disputeMatter.disputeArea',
            'complaintRegistration.priority',
            'complaintRegistration.fiscalYear',
            'complaintRegistration.parties.permanentDistrict',
            'complaintRegistration.parties.permanentLocalBody',
            'complaintRegistration.parties.temporaryDistrict',
            'complaintRegistration.parties.temporaryLocalBody'
        ])->findOrFail($request->route('id'));


        return view('Ejalas::dispute-deadline.preview', compact('disputeDeadline'));
    }
    public function report()
    {
        return view('Ejalas::dispute-deadline.report');
    }
}
