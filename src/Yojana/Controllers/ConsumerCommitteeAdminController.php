<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ConsumerCommittee;
use Src\Yojana\Models\LetterSample;
use Src\Yojana\Models\LetterType;
use Src\Yojana\Models\WorkOrder;

class ConsumerCommitteeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:consumer_committees view')->only('index');
        //$this->middleware('permission:consumer_committees edit')->only('edit');
        //$this->middleware('permission:consumer_committees create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::consumer-committees.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::consumer-committees.form')->with(compact('action'));
    }

    function edit(Request $request){
        $consumerCommittee = ConsumerCommittee::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::consumer-committees.form')->with(compact('action','consumerCommittee'));
    }

    function preview(Request $request)
    {
        $consumerCommittee = ConsumerCommittee::find($request->route('id'));
        $letterType = $request->letterType;
        return view('Yojana::consumer-committees.preview', compact('consumerCommittee', 'letterType'));
    }

}
