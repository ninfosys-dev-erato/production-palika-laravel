<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\BenefitedMemberDetail;

class BenefitedMemberDetailAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:benefited_member_details view')->only('index');
        //$this->middleware('permission:benefited_member_details edit')->only('edit');
        //$this->middleware('permission:benefited_member_details create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::benefited-member-details.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::benefited-member-details.form')->with(compact('action'));
    }

    function edit(Request $request){
        $benefitedMemberDetail = BenefitedMemberDetail::find($request->route('id'));
        $action = Action::UPDATE;
        return view('BenefitedMemberDetails::form')->with(compact('action','benefitedMemberDetail'));
    }

}
