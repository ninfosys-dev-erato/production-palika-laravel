<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\JudicialMeeting;
// use function Src\JudicialMeetings\Controllers\view;

class JudicialMeetingAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:judicial_meetings view')->only('index');
        //$this->middleware('permission:judicial_meetings edit')->only('edit');
        //$this->middleware('permission:judicial_meetings create')->only('create');
    }

    function index(Request $request)
    {
        return view('Ejalas::judicial-meeting.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ejalas::judicial-meeting.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $judicialMeeting = JudicialMeeting::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::judicial-meeting.form')->with(compact('action', 'judicialMeeting'));
    }
    function preview(Request $request)
    {
        $judicialMeeting = JudicialMeeting::find($request->route('id'));
        return view('Ejalas::judicial-meeting.preview', compact('judicialMeeting'));
    }
    function report()
    {
        return view('Ejalas::judicial-meeting.report');
    }
}
