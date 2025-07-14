<?php

namespace Src\TokenTracking\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\TokenTracking\Models\TokenLog;

class TokenLogAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:token_logs view')->only('index');
        //$this->middleware('permission:token_logs edit')->only('edit');
        //$this->middleware('permission:token_logs create')->only('create');
    }

    function index(Request $request){
        return view('TokenLogs::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('TokenLogs::form')->with(compact('action'));
    }

    function edit(Request $request){
        $tokenLog = TokenLog::find($request->route('id'));
        $action = Action::UPDATE;
        return view('TokenLogs::form')->with(compact('action','tokenLog'));
    }

}
