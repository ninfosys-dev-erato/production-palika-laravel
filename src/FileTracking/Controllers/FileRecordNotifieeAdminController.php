<?php

namespace Src\FileTracking\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\FileTracking\Models\FileRecordNotifiee;

class FileRecordNotifieeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:file_record_notifiees view')->only('index');
        //$this->middleware('permission:file_record_notifiees edit')->only('edit');
        //$this->middleware('permission:file_record_notifiees create')->only('create');
    }

    function index(Request $request){
        return view('FileTracking::file-record-notifee.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('FileTracking::file-record-notifee.form')->with(compact('action'));
    }

    function edit(Request $request){
        $fileRecordNotifiee = FileRecordNotifiee::find($request->route('id'));
        $action = Action::UPDATE;
        return view('FileTracking::file-record-notifee.form')->with(compact('action','fileRecordNotifiee'));
    }

}
