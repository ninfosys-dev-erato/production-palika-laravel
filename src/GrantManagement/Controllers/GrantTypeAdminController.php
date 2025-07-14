<?php

namespace Src\GrantManagement\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\GrantManagement\Models\GrantType;

class GrantTypeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:grant_types view')->only('index');
        //$this->middleware('permission:grant_types edit')->only('edit');
        //$this->middleware('permission:grant_types create')->only('create');
    }

    function index(Request $request){
        return view('GrantManagement::grant-types.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('GrantManagement::grant-types.form')->with(compact('action'));
    }

    function edit(Request $request){
        $grantType = GrantType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('GrantManagement::grant-types.form')->with(compact('action','grantType'));
    }

}
