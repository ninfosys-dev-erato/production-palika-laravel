<?php

namespace Src\GrantManagement\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\GrantManagement\Models\EnterpriseFarmer;

class EnterpriseFarmerAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:enterprise_farmers view')->only('index');
        //$this->middleware('permission:enterprise_farmers edit')->only('edit');
        //$this->middleware('permission:enterprise_farmers create')->only('create');
    }

    function index(Request $request){
        return view('GrantManagement::enterprise-farmers.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('GrantManagement::enterprise-farmers.form')->with(compact('action'));
    }

    function edit(Request $request){
        $enterpriseFarmer = EnterpriseFarmer::find($request->route('id'));
        $action = Action::UPDATE;
        return view('GrantManagement::enterprise-farmers.form')->with(compact('action','enterpriseFarmer'));
    }

}
