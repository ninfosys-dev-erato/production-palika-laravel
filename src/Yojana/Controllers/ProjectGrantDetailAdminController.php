<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ProjectGrantDetail;

class ProjectGrantDetailAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:project_grant_details view')->only('index');
        //$this->middleware('permission:project_grant_details edit')->only('edit');
        //$this->middleware('permission:project_grant_details create')->only('create');
    }

    function index(Request $request){
        return view('ProjectGrantDetails::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('ProjectGrantDetails::form')->with(compact('action'));
    }

    function edit(Request $request){
        $projectGrantDetail = ProjectGrantDetail::find($request->route('id'));
        $action = Action::UPDATE;
        return view('ProjectGrantDetails::form')->with(compact('action','projectGrantDetail'));
    }

}
