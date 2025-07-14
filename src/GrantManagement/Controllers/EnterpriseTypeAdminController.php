<?php

namespace Src\GrantManagement\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\GrantManagement\Models\EnterpriseType;

class EnterpriseTypeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:enterprise_types view')->only('index');
        //$this->middleware('permission:enterprise_types edit')->only('edit');
        //$this->middleware('permission:enterprise_types create')->only('create');
    }

    function index(Request $request){
        return view('GrantManagement::enterprise-types.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('GrantManagement::enterprise-types.form')->with(compact('action'));
    }

    function edit(Request $request){
        $enterpriseType = EnterpriseType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('GrantManagement::enterprise-types.form')->with(compact('action','enterpriseType'));
    }

}
