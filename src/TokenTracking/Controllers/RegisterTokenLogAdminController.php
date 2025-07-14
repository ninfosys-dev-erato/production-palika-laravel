<?php

namespace Src\TokenTracking\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\TokenTracking\Models\RegisterTokenLog;

class RegisterTokenLogAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:register_token_logs view')->only('index');
        //$this->middleware('permission:register_token_logs edit')->only('edit');
        //$this->middleware('permission:register_token_logs create')->only('create');
    }

    function index(Request $request){
        return view('TokenTracking::register-token-logs.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('TokenTracking::register-token-logs.form')->with(compact('action'));
    }

    function edit(Request $request){
        $registerTokenLog = RegisterTokenLog::find($request->route('id'));
        $action = Action::UPDATE;
        return view('TokenTracking::register-token-logs.form')->with(compact('action','registerTokenLog'));
    }

}
