<?php

namespace Src\Districts\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Districts\Models\District;

class DistrictAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:districts view')->only('index');
        //$this->middleware('permission:districts edit')->only('edit');
        //$this->middleware('permission:districts create')->only('create');
    }

    function index(Request $request){
        return view('Districts::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Districts::form')->with(compact('action'));
    }

    function edit(Request $request){
        $district = District::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Districts::form')->with(compact('action','district'));
    }

}
