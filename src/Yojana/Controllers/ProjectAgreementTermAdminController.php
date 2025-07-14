<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ProjectAgreementTerm;

class ProjectAgreementTermAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:project_agreement_terms view')->only('index');
        //$this->middleware('permission:project_agreement_terms edit')->only('edit');
        //$this->middleware('permission:project_agreement_terms create')->only('create');
    }

    function index(Request $request){
        return view('project-agreement-terms::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('project-agreement-terms::form')->with(compact('action'));
    }

    function edit(Request $request){
        $projectAgreementTerm = ProjectAgreementTerm::find($request->route('id'));
        $action = Action::UPDATE;
        return view('project-agreement-terms::form')->with(compact('action','projectAgreementTerm'));
    }

}
