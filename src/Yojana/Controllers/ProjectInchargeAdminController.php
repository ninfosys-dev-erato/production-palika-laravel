<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ProjectIncharge;

class ProjectInchargeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:project_incharges view')->only('index');
        //$this->middleware('permission:project_incharges edit')->only('edit');
        //$this->middleware('permission:project_incharges create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::project-incharge.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::project-incharge.form')->with(compact('action'));
    }

    function edit(Request $request){
        $projectIncharge = ProjectIncharge::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::project-incharge.form')->with(compact('action','projectIncharge'));
    }

}
