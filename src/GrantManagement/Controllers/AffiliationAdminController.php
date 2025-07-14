<?php

namespace Src\GrantManagement\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\GrantManagement\Models\Affiliation;

class AffiliationAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:affiliations view')->only('index');
        //$this->middleware('permission:affiliations edit')->only('edit');
        //$this->middleware('permission:affiliations create')->only('create');
    }

    function index(Request $request){
        return view('GrantManagement::affiliations.index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('GrantManagement::affiliations.form')->with(compact('action'));
    }

    function edit(Request $request){
        $affiliation = Affiliation::find($request->route('id'));
        $action = Action::UPDATE;
        return view('GrantManagement::affiliations.form')->with(compact('action','affiliation'));
    }

}
