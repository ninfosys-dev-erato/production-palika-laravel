<?php

namespace Src\Meetings\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\Meetings\Models\Agenda;
use Src\Meetings\Models\Decision;
use Src\Meetings\Models\Meeting;
use Src\Meetings\Models\Minute;

class MeetingAdminController extends Controller implements HasMiddleware
{

    public static function middleware()
    {
        return [
            new Middleware('permission:meeting_access', only: ['index']),
            new Middleware('permission:meeting_create', only: ['create']),
            new Middleware('permission:meeting_update', only: ['edit']),
        ];
    }

    // Meeting list view
    public function index(Request $request)
    {
        return view('Meetings::index');
    }

    // Create new meeting
    public function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Meetings::form')->with(compact('action'));
    }

    // Edit existing meeting
    public function edit(Request $request)
    {
        $meeting = Meeting::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Meetings::form')->with(compact('action', 'meeting'));
    }

    // View and manage meeting minutes
    public function minutes(Request $request)
    {
        $meeting = Meeting::with('minutes')->find($request->route('id'));
        if (!$meeting) {
            return redirect()->route('admin.meetings.index')->with('error', 'Meeting not found.');
        }

        return view('Minutes::index', compact('meeting'));
    }

    // Store or update meeting minutes
    public function storeMinutes(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:1000',
            // Validate other fields if necessary
        ]);

        $meeting = Meeting::find($request->route('id'));
        if (!$meeting) {
            return redirect()->back()->with('error', 'Meeting not found.');
        }

        Minute::updateOrCreate(
            ['meeting_id' => $meeting->id], // Use the meeting_id to find or create
            [
                'description' => $request->input('description'),
                'created_by' => auth()->id(), // Store the ID of the user creating the minute
                'created_at' => now(), // Use now() for created_at
                'updated_at' => now(), // Use now() for updated_at
            ]
        );

        return redirect()->route('admin.meetings.index')->with('success', 'Minutes saved successfully.');
    }

    // View decisions related to a meeting
    public function decisions(Request $request)
    {
        $meeting = Meeting::with('decisions')->find($request->route('id'));
        if (!$meeting) {
            return redirect()->route('admin.meetings.index')->with('error', 'Meeting not found.');
        }

        return view('Decisions::index', compact('meeting'));
    }

    // Store or update decisions related to a meeting
    public function storeDecisions(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'chairman' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            // Add other necessary validation rules based on your requirements
        ]);

        $meeting = Meeting::find($request->route('id'));
        if (!$meeting) {
            return redirect()->back()->with('error', 'Meeting not found.');
        }

        Decision::updateOrCreate(
            ['meeting_id' => $meeting->id],
            [
                'date' => $request->input('date'),
                'chairman' => $request->input('chairman'),
                'description' => $request->input('description'),
                'user_id' => auth()->id(), // Assuming you want to set the user who created/updated
                'created_at' => now(), // Set created_at if creating
                'updated_at' => now(), // Set updated_at if creating
            ]
        );

        return redirect()->route('admin.meetings.index')->with('success', 'Decision saved successfully.');
    }

    public function manage(Request $request)
    {
        $meeting = Meeting::with(['fiscalYear', 'committee', 'minute', 'decisions', 'agendas', 'invitedMembers'])->find($request->route('id'));
        if (!$meeting) {
            return redirect()->route('admin.meetings.index')->with('error', 'Meeting not found.');
        }
        $agenda = Agenda::find($request->route('id'));
        $minute = Minute::where('meeting_id', $meeting->id)->first();
        $action = Action::CREATE;
        return view('Meetings::manage', compact('meeting','action', 'agenda', 'minute'));
    }
}