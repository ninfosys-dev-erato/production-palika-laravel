<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ProjectActivityGroup;

class ProjectActivityGroupAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:project_activity_groups view')->only('index');
        //$this->middleware('permission:project_activity_groups edit')->only('edit');
        //$this->middleware('permission:project_activity_groups create')->only('create');
    }

    function index(Request $request)
    {
        return view('Yojana::project-activity-groups.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::project-activity-groups.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $projectActivityGroup = ProjectActivityGroup::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::project-activity-groups.form')->with(compact('action', 'projectActivityGroup'));
    }
}
