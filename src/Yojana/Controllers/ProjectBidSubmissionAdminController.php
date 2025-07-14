<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ProjectBidSubmission;

class ProjectBidSubmissionAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:project_bid_submissions view')->only('index');
        //$this->middleware('permission:project_bid_submissions edit')->only('edit');
        //$this->middleware('permission:project_bid_submissions create')->only('create');
    }

    function index(Request $request){
        return view('project-bid-submissions::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('project-bid-submissions::form')->with(compact('action'));
    }

    function edit(Request $request){
        $projectBidSubmission = ProjectBidSubmission::find($request->route('id'));
        $action = Action::UPDATE;
        return view('project-bid-submissions::form')->with(compact('action','projectBidSubmission'));
    }

}
