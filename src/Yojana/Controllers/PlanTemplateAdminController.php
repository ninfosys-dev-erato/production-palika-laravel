<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\PlanTemplate;

class PlanTemplateAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:plan_templates view')->only('index');
        //$this->middleware('permission:plan_templates edit')->only('edit');
        //$this->middleware('permission:plan_templates create')->only('create');
    }

    function index(Request $request){
        return view('PlanTemplates::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('PlanTemplates::form')->with(compact('action'));
    }

    function edit(Request $request){
        $planTemplate = PlanTemplate::find($request->route('id'));
        $action = Action::UPDATE;
        return view('PlanTemplates::form')->with(compact('action','planTemplate'));
    }

}
