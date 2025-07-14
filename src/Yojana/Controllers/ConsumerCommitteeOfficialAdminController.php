<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ConsumerCommitteeOfficial;

class ConsumerCommitteeOfficialAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:consumer_committee_officials view')->only('index');
        //$this->middleware('permission:consumer_committee_officials edit')->only('edit');
        //$this->middleware('permission:consumer_committee_officials create')->only('create');
    }

    function index(Request $request){
        return view('ConsumerCommitteeOfficials::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('ConsumerCommitteeOfficials::form')->with(compact('action'));
    }

    function edit(Request $request){
        $consumerCommitteeOfficial = ConsumerCommitteeOfficial::find($request->route('id'));
        $action = Action::UPDATE;
        return view('ConsumerCommitteeOfficials::form')->with(compact('action','consumerCommitteeOfficial'));
    }

}
