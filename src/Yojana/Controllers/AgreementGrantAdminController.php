<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\AgreementGrant;

class AgreementGrantAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:agreement_grants view')->only('index');
        //$this->middleware('permission:agreement_grants edit')->only('edit');
        //$this->middleware('permission:agreement_grants create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::agreement-grants.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::agreement-grants.form')->with(compact('action'));
    }

    function edit(Request $request){
        $agreementGrant = AgreementGrant::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::agreement-grants.form')->with(compact('action','agreementGrant'));
    }

}
