<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\BankDetail;

class BankDetailAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:bank_details view')->only('index');
        //$this->middleware('permission:bank_details edit')->only('edit');
        //$this->middleware('permission:bank_details create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::bank-details.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::bank-details.form')->with(compact('action'));
    }

    function edit(Request $request){
        $bankDetail = BankDetail::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::bank-details.form')->with(compact('action','bankDetail'));
    }

}
