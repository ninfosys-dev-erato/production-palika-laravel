<?php

namespace Src\TokenTracking\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\TokenTracking\Models\TokenFeedback;

class TokenFeedbackAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:token_feedbacks view')->only('index');
        //$this->middleware('permission:token_feedbacks edit')->only('edit');
        //$this->middleware('permission:token_feedbacks create')->only('create');
    }

    function index(Request $request){
        return view('TokenTracking::token-feedbacks.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('TokenTracking::token-feedbacks.form')->with(compact('action'));
    }

    function edit(Request $request){
        $tokenFeedback = TokenFeedback::find($request->route('id'));
        $action = Action::UPDATE;
        return view('TokenTracking::token-feedbacks.form')->with(compact('action','tokenFeedback'));
    }

}
