<?php

namespace Src\GrantManagement\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\GrantManagement\Models\CooperativeType;

class CooperativeTypeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:cooperative_types view')->only('index');
        //$this->middleware('permission:cooperative_types edit')->only('edit');
        //$this->middleware('permission:cooperative_types create')->only('create');
    }

    function index(Request $request){
        return view('GrantManagement::cooperative-types.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('GrantManagement::cooperative-types.form')->with(compact('action'));
    }

    function edit(Request $request){
        $cooperativeType = CooperativeType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('GrantManagement::cooperative-types.form')->with(compact('action','cooperativeType'));
    }

}
