<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\Agreement;

class AgreementAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:agreements view')->only('index');
        //$this->middleware('permission:agreements edit')->only('edit');
        //$this->middleware('permission:agreements create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::agreements.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::agreements.form')->with(compact('action'));
    }

    function edit(Request $request){
        $agreement = Agreement::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::agreements.form')->with(compact('action','agreement'));
    }

}
