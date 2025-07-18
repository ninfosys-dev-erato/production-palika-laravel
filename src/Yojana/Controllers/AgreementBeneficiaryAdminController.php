<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\AgreementBeneficiary;

class AgreementBeneficiaryAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:agreement_beneficiaries view')->only('index');
        //$this->middleware('permission:agreement_beneficiaries edit')->only('edit');
        //$this->middleware('permission:agreement_beneficiaries create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::agreement-beneficiaries.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::agreement-beneficiaries.form')->with(compact('action'));
    }

    function edit(Request $request){
        $agreementBeneficiary = AgreementBeneficiary::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::agreement-beneficiaries.form')->with(compact('action','agreementBeneficiary'));
    }

}
