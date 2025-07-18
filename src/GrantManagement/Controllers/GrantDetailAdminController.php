<?php

namespace Src\GrantManagement\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\GrantManagement\Models\GrantDetail;

class GrantDetailAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:grant_details view')->only('index');
        //$this->middleware('permission:grant_details edit')->only('edit');
        //$this->middleware('permission:grant_details create')->only('create');
    }

    function index(Request $request){
        return view('GrantManagement::grant-details.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('GrantManagement::grant-details.form')->with(compact('action'));
    }

    function edit(Request $request){
        $grantDetail = GrantDetail::find($request->route('id'));
        $action = Action::UPDATE;
        return view('GrantManagement::grant-details.form')->with(compact('action','grantDetail'));
    }

}
