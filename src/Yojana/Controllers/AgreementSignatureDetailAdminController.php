<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\AgreementSignatureDetail;

class AgreementSignatureDetailAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:agreement_signature_details view')->only('index');
        //$this->middleware('permission:agreement_signature_details edit')->only('edit');
        //$this->middleware('permission:agreement_signature_details create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::agreement-signature-details.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::agreement-signature-details.form')->with(compact('action'));
    }

    function edit(Request $request){
        $agreementSignatureDetail = AgreementSignatureDetail::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::agreement-signature-details.form')->with(compact('action','agreementSignatureDetail'));
    }

}
