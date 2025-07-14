<?php

namespace Src\GrantManagement\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\GrantManagement\Models\FarmerGroup;

class FarmerGroupAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:farmer_groups view')->only('index');
        //$this->middleware('permission:farmer_groups edit')->only('edit');
        //$this->middleware('permission:farmer_groups create')->only('create');
    }

    function index(Request $request){
        return view('GrantManagement::farmer-groups.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('GrantManagement::farmer-groups.form')->with(compact('action'));
    }

    function edit(Request $request){
        $farmerGroup = FarmerGroup::find($request->route('id'));
        $action = Action::UPDATE;
        return view('GrantManagement::farmer-groups.form')->with(compact('action','farmerGroup'));
    }

}
