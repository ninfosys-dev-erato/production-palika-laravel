<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\CargoHandling;

class CargoHandlingAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:cargo_handlings view')->only('index');
        //$this->middleware('permission:cargo_handlings edit')->only('edit');
        //$this->middleware('permission:cargo_handlings create')->only('create');
    }

    function index(Request $request){
        return view('CargoHandlings::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('CargoHandlings::form')->with(compact('action'));
    }

    function edit(Request $request){
        $cargoHandling = CargoHandling::find($request->route('id'));
        $action = Action::UPDATE;
        return view('CargoHandlings::form')->with(compact('action','cargoHandling'));
    }

}
