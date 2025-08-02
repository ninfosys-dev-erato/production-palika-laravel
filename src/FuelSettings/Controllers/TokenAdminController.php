<?php

namespace Src\FuelSettings\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Tokens\Models\Token;

class TokenAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:tokens view')->only('index');
        //$this->middleware('permission:fms_tokens edit')->only('edit');
        //$this->middleware('permission:fms_tokens create')->only('create');
    }

    function index(Request $request)
    {
        return view('FuelSettings::tokens.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('FuelSettings::tokens.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $token = Token::find($request->route('id'));
        $action = Action::UPDATE;
        return view('FuelSettings::tokens.form')->with(compact('action', 'token'));
    }
}
