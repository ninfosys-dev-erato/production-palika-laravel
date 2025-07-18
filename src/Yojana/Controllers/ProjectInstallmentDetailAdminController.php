<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ProjectInstallmentDetail;

class ProjectInstallmentDetailAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:project_installment_details view')->only('index');
        //$this->middleware('permission:project_installment_details edit')->only('edit');
        //$this->middleware('permission:project_installment_details create')->only('create');
    }

    function index(Request $request){
        return view('ProjectInstallmentDetails::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('ProjectInstallmentDetails::form')->with(compact('action'));
    }

    function edit(Request $request){
        $projectInstallmentDetail = ProjectInstallmentDetail::find($request->route('id'));
        $action = Action::UPDATE;
        return view('ProjectInstallmentDetails::form')->with(compact('action','projectInstallmentDetail'));
    }

}
