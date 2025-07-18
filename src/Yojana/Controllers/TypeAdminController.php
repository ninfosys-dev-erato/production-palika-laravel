<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\Type;

class TypeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:types view')->only('index');
        //$this->middleware('permission:types edit')->only('edit');
        //$this->middleware('permission:types create')->only('create');
    }

    function index(Request $request){
        return view('Yojana::types.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Yojana::types.form')->with(compact('action'));
    }

    function edit(Request $request){
        $type = Type::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Yojana::types.form')->with(compact('action','type'));
    }

}
