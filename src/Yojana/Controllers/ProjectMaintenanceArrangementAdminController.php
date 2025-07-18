<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ProjectMaintenanceArrangement;

class ProjectMaintenanceArrangementAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:project_maintenance_arrangements view')->only('index');
        //$this->middleware('permission:project_maintenance_arrangements edit')->only('edit');
        //$this->middleware('permission:project_maintenance_arrangements create')->only('create');
    }

    function index(Request $request){
        return view('ProjectMaintenanceArrangements::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('ProjectMaintenanceArrangements::form')->with(compact('action'));
    }

    function edit(Request $request){
        $projectMaintenanceArrangement = ProjectMaintenanceArrangement::find($request->route('id'));
        $action = Action::UPDATE;
        return view('ProjectMaintenanceArrangements::form')->with(compact('action','projectMaintenanceArrangement'));
    }

}
