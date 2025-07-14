<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\CourtSubmission;

class CourtSubmissionAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:court_submissions view')->only('index');
        //$this->middleware('permission:court_submissions edit')->only('edit');
        //$this->middleware('permission:court_submissions create')->only('create');
    }

    function index(Request $request)
    {
        return view('Ejalas::court-submission.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ejalas::court-submission.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $courtSubmission = CourtSubmission::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::court-submission.form')->with(compact('action', 'courtSubmission'));
    }
    function preview(Request $request)
    {
        $courtSubmission = CourtSubmission::find($request->route('id'));
        return view('Ejalas::court-submission.preview', compact('courtSubmission'));
    }
    function report(Request $request)
    {
        return view('Ejalas::court-submission.report');
    }
}
