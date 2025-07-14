<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ProjectBidDetail;

class ProjectBidDetailAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:project_bid_details view')->only('index');
        //$this->middleware('permission:project_bid_details edit')->only('edit');
        //$this->middleware('permission:project_bid_details create')->only('create');
    }

    function index(Request $request){
        return view('ProjectBidDetails::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('ProjectBidDetails::form')->with(compact('action'));
    }

    function edit(Request $request){
        $projectBidDetail = ProjectBidDetail::find($request->route('id'));
        $action = Action::UPDATE;
        return view('ProjectBidDetails::form')->with(compact('action','projectBidDetail'));
    }

}
