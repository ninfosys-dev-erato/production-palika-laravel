<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ProjectAllocatedAmount;

class ProjectAllocatedAmountAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:project_allocated_amounts view')->only('index');
        //$this->middleware('permission:project_allocated_amounts edit')->only('edit');
        //$this->middleware('permission:project_allocated_amounts create')->only('create');
    }

    function index(Request $request){
        return view('ProjectAllocatedAmounts::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('ProjectAllocatedAmounts::form')->with(compact('action'));
    }

    function edit(Request $request){
        $projectAllocatedAmount = ProjectAllocatedAmount::find($request->route('id'));
        $action = Action::UPDATE;
        return view('ProjectAllocatedAmounts::form')->with(compact('action','projectAllocatedAmount'));
    }

}
