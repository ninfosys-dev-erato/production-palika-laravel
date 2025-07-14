<?php

namespace Src\FileTracking\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\FileTracking\Models\FileRecord;
use Src\FileTracking\Models\FileRecordLog;

class FileRecordAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:file_records view')->only('index');
        //$this->middleware('permission:file_records edit')->only('edit');
        //$this->middleware('permission:file_records create')->only('create');
    }

    function index(Request $request)
    {
        return view('FileTracking::file-tracking.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('FileTracking::file-tracking.form')->with(compact('action'));
    }

    function manage(Request $request)
    {
        $action = Action::CREATE;
        return view('FileTracking::file-tracking.manage')->with(compact('action'));
    }


    function starred(Request $request)
    {
        return view('FileTracking::file-tracking.starred');
    }

    function edit(Request $request)
    {
        $fileRecord = FileRecord::find($request->route('id'));
        $action = Action::UPDATE;
        return view('FileTracking::file-tracking.form')->with(compact('action', 'fileRecord'));
    }

    function darta(Request $request)
    {
        $action = Action::CREATE;
        return view('FileTracking::file-tracking.file-tracking-form')->with(compact('action'));
    }

    function show(Request $request)
    {
        $fileRecord = FileRecord::with('subject')->find($request->route('id'));
        $fileRecordLog = FileRecordLog::with('handler')->where('reg_id', $fileRecord->id)->get();

        return view('FileTracking::file-tracking.show')->with(compact('fileRecord', 'fileRecordLog'));
    }

    public function inbox(Request $request)
    {
        $fileRecord = FileRecord::with('subject')->findOrFail($request->route('id'));
        return view('FileTracking::file-tracking.inbox', compact('fileRecord'));
    }

    public function compose()
    {
        return view('FileTracking::file-tracking.compose');
    }


    public function sent()
    {
        return view('FileTracking::file-tracking.sent');
    }
}
