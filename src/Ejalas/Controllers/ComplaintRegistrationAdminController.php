<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\ComplaintRegistration;
use Src\Ejalas\Models\Party;

class ComplaintRegistrationAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:complaint_registrations view')->only('index');
        //$this->middleware('permission:complaint_registrations edit')->only('edit');
        //$this->middleware('permission:complaint_registrations create')->only('create');
    }

    function index(Request $request)
    {
        $from = ($request->from);
        return view('Ejalas::complaint-registration.index')->with(compact('from'));
    }

    function create(Request $request, $from = null)
    {
        $action = Action::CREATE;
        return view('Ejalas::complaint-registration.form')->with(compact('action', 'from'));
    }

    function edit(Request $request, $from = null)
    {
        $complaintRegistration = ComplaintRegistration::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::complaint-registration.form')->with(compact('action', 'complaintRegistration', 'from'));
    }
    function view(Request $request)
    {
        // Retrieve the complaint registration
        $complaintRegistration = ComplaintRegistration::with('parties')->findOrFail($request->route('id'));
        $partyDetails = $complaintRegistration->parties->groupBy('pivot.role');

        // Extract Defender and Complainer details
        $defenderDetails = $partyDetails->get('Defender', collect());
        $complainerDetails = $partyDetails->get('Complainer', collect());

        return view('Ejalas::complaint-registration.view', compact('complaintRegistration', 'defenderDetails', 'complainerDetails'));
    }
    public function preview(Request $request, $id)
    {
        $complaintRegistration = ComplaintRegistration::findOrFail($id);
        return view('Ejalas::complaint-registration.preview')->with(compact('complaintRegistration'));
        // $id = $request->route('id');
        // return view('Ejalas::complaint-registration.preview')->with(compact('id'));
    }
    public function report()
    {

        return view('Ejalas::complaint-registration.report');
    }
    function fiscalYearReport()
    {
        return view('Ejalas::fiscal-year.report');
    }

    function reconciliationIndex()
    {
        return view('Ejalas::complaint-registration.reconciliation-center.index');
    }
}
