<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ProjectGroup;

class ProjectGroupAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:project_groups view')->only('index');
        //$this->middleware('permission:project_groups edit')->only('edit');
        //$this->middleware('permission:project_groups create')->only('create');
    }

    function index(Request $request)
    {
        return view('Yojana::project-groups.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Yojana::project-groups.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $projectGroup = ProjectGroup::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::project-groups.form')->with(compact('action', 'projectGroup'));
    }
}
