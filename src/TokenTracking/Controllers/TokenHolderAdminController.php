<?php

namespace Src\TokenTracking\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\TokenTracking\Models\TokenHolder;

class TokenHolderAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:token_holders view')->only('index');
        //$this->middleware('permission:token_holders edit')->only('edit');
        //$this->middleware('permission:token_holders create')->only('create');
    }

    function index(Request $request){
        return view('TokenTracking::token-holders.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('TokenTracking::token-holders.form')->with(compact('action'));
    }

    function edit(Request $request){
        $tokenHolder = TokenHolder::find($request->route('id'));
        $action = Action::UPDATE;
        return view('TokenTracking::token-holders.form')->with(compact('action','tokenHolder'));
    }

}
