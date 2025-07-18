<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\AdvancePayment;

class AdvancePaymentAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:advance_payments view')->only('index');
        //$this->middleware('permission:advance_payments edit')->only('edit');
        //$this->middleware('permission:advance_payments create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::advance-payments.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::advance-payments.form')->with(compact('action'));
    }

    function edit(Request $request){
        $advancePayment = AdvancePayment::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::advance-payments.form')->with(compact('action','advancePayment'));
    }

}
