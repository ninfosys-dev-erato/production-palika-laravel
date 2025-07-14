<?php

namespace Src\FileTracking\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\FileTracking\Models\FileRecordLog;

class FileRecordLogAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:file_record_logs view')->only('index');
        //$this->middleware('permission:file_record_logs edit')->only('edit');
        //$this->middleware('permission:file_record_logs create')->only('create');
    }

    function index(Request $request){
        return view('FileTracking::file-record-log.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('FileTracking::file-record-log.form')->with(compact('action'));
    }

    function edit(Request $request){
        $fileRecordLog = FileRecordLog::find($request->route('id'));
        $action = Action::UPDATE;
        return view('FileTracking::file-record-log.form')->with(compact('action','fileRecordLog'));
    }

}
