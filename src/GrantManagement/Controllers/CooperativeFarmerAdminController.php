<?php

namespace Src\GrantManagement\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\GrantManagement\Models\CooperativeFarmer;

class CooperativeFarmerAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:cooperative_farmers view')->only('index');
        //$this->middleware('permission:cooperative_farmers edit')->only('edit');
        //$this->middleware('permission:cooperative_farmers create')->only('create');
    }

    function index(Request $request){
        return view('GrantManagement::cooperative-farmers.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('GrantManagement::cooperative-farmers.form')->with(compact('action'));
    }

    function edit(Request $request){
        $cooperativeFarmer = CooperativeFarmer::find($request->route('id'));
        $action = Action::UPDATE;
        return view('GrantManagement::cooperative-farmers.form')->with(compact('action','cooperativeFarmer'));
    }

}
