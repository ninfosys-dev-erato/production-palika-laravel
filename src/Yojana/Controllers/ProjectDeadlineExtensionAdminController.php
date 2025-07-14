<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ProjectDeadlineExtension;

class ProjectDeadlineExtensionAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:project_deadline_extensions view')->only('index');
        //$this->middleware('permission:project_deadline_extensions edit')->only('edit');
        //$this->middleware('permission:project_deadline_extensions create')->only('create');
    }

    function index(Request $request){
        return view('ProjectDeadlineExtensions::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('ProjectDeadlineExtensions::form')->with(compact('action'));
    }

    function edit(Request $request){
        $projectDeadlineExtension = ProjectDeadlineExtension::find($request->route('id'));
        $action = Action::UPDATE;
        return view('ProjectDeadlineExtensions::form')->with(compact('action','projectDeadlineExtension'));
    }

}
