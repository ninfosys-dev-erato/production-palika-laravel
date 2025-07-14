<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\Fuel;

class FuelAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:fuels view')->only('index');
        //$this->middleware('permission:fuels edit')->only('edit');
        //$this->middleware('permission:fuels create')->only('create');
    }

    function index(Request $request){
        return view('Fuels::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Fuels::form')->with(compact('action'));
    }

    function edit(Request $request){
        $fuel = Fuel::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Fuels::form')->with(compact('action','fuel'));
    }

}
