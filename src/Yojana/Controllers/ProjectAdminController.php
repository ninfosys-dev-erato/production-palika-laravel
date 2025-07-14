<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\Project;

class ProjectAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:projects view')->only('index');
        //$this->middleware('permission:projects edit')->only('edit');
        //$this->middleware('permission:projects create')->only('create');
    }

    function index(Request $request){
        return view('Projects::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Projects::form')->with(compact('action'));
    }

    function edit(Request $request){
        $project = Project::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Projects::form')->with(compact('action','project'));
    }

}
