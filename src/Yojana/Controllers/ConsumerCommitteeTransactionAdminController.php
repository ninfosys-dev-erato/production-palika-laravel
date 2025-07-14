<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ConsumerCommitteeTransaction;

class ConsumerCommitteeTransactionAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:consumer_committee_transactions view')->only('index');
        //$this->middleware('permission:consumer_committee_transactions edit')->only('edit');
        //$this->middleware('permission:consumer_committee_transactions create')->only('create');
    }

    function index(Request $request){
        return view('consumer-committee-transactions::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('consumer-committee-transactions::form')->with(compact('action'));
    }

    function edit(Request $request){
        $consumerCommitteeTransaction = ConsumerCommitteeTransaction::find($request->route('id'));
        $action = Action::UPDATE;
        return view('consumer-committee-transactions::form')->with(compact('action','consumerCommitteeTransaction'));
    }

}
