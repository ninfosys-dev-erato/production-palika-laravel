<?php

namespace Src\Provinces\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Provinces\Models\Province;

class ProvinceAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:provinces view')->only('index');
        //$this->middleware('permission:provinces edit')->only('edit');
        //$this->middleware('permission:provinces create')->only('create');
    }

    function index(Request $request){
        return view('Provinces::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Provinces::form')->with(compact('action'));
    }

    function edit(Request $request){
        $province = Province::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Provinces::form')->with(compact('action','province'));
    }

}
