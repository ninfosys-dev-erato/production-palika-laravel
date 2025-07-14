<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ConsumerCommitteeMember;

class ConsumerCommitteeMemberAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:consumer_committee_members view')->only('index');
        //$this->middleware('permission:consumer_committee_members edit')->only('edit');
        //$this->middleware('permission:consumer_committee_members create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::consumer-committee-members.index');
    }

    function create(Request $request, $consumerCommitteeId){
        $action = Action::CREATE;
        return view('Yojana::consumer-committee-members.form')->with(compact('action','consumerCommitteeId'));
    }

    function edit(Request $request){
        $consumerCommitteeMember = ConsumerCommitteeMember::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::consumer-committee-members.form')->with(compact('action','consumerCommitteeMember'));
    }

}
