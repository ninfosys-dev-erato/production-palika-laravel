<?php

namespace Src\GrantManagement\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\GrantManagement\Models\HelplessnessType;

class HelplessnessTypeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:helplessness_types view')->only('index');
        //$this->middleware('permission:helplessness_types edit')->only('edit');
        //$this->middleware('permission:helplessness_types create')->only('create');
    }

    function index(Request $request){
        return view('GrantManagement::helplessness-types.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('GrantManagement::helplessness-types.form')->with(compact('action'));
    }

    function edit(Request $request){
        $helplessnessType = HelplessnessType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('GrantManagement::helplessness-types.form')->with(compact('action','helplessnessType'));
    }

}
