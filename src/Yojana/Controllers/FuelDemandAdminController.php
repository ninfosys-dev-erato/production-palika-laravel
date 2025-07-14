<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\FuelDemand;

class FuelDemandAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:fuel_demands view')->only('index');
        //$this->middleware('permission:fuel_demands edit')->only('edit');
        //$this->middleware('permission:fuel_demands create')->only('create');
    }

    function index(Request $request){
        return view('FuelDemands::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('FuelDemands::form')->with(compact('action'));
    }

    function edit(Request $request){
        $fuelDemand = FuelDemand::find($request->route('id'));
        $action = Action::UPDATE;
        return view('FuelDemands::form')->with(compact('action','fuelDemand'));
    }

}
