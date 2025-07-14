<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\DisputeRegistrationCourt;

class DisputeRegistrationCourtAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:dispute_registration_courts view')->only('index');
        //$this->middleware('permission:dispute_registration_courts edit')->only('edit');
        //$this->middleware('permission:dispute_registration_courts create')->only('create');
    }

    function index(Request $request)
    {
        return view('Ejalas::dispute-registration-court.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ejalas::dispute-registration-court.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $disputeRegistrationCourt = DisputeRegistrationCourt::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::dispute-registration-court.form')->with(compact('action', 'disputeRegistrationCourt'));
    }
    // public function preview(Request $request, $id)
    // {

    //     $disputeRegistrationCourt = DisputeRegistrationCourt::with('complaintRegistration', 'judicialEmployee', 'judicialEmployee.designation')->findOrFail($id);
    //     $complaint = ComplaintRegistration::with([
    //         'disputeMatter',
    //         'priority',
    //         'fiscalYear',
    //         'parties.permanentDistrict',
    //         'parties.permanentLocalBody',
    //         'parties.temporaryDistrict',
    //         'parties.temporaryLocalBody',
    //         'disputeMatter.disputeArea'
    //     ])
    //         ->where('id', $disputeRegistrationCourt->complaint_registration_id)
    //         ->first();

    //     $complainers = $complaint ? $complaint->parties->where('type', 'Complainer') : collect();
    //     $defenders = $complaint ? $complaint->parties->where('type', 'Defender') : collect();

    //     return view('Ejalas::dispute-registration-court.preview', compact('disputeRegistrationCourt', 'complaint', 'complainers', 'defenders'));
    // }

    public function preview(Request $request, $id)
    {
        $disputeRegistrationCourt = DisputeRegistrationCourt::findOrFail($id);
        return view('Ejalas::dispute-registration-court.preview')->with(compact('disputeRegistrationCourt'));
    }
}
