<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\FuelRate;

class FuelRateAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:fuel_rates view')->only('index');
        //$this->middleware('permission:fuel_rates edit')->only('edit');
        //$this->middleware('permission:fuel_rates create')->only('create');
    }

    function index(Request $request){
        return view('FuelRates::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('FuelRates::form')->with(compact('action'));
    }

    function edit(Request $request){
        $fuelRate = FuelRate::find($request->route('id'));
        $action = Action::UPDATE;
        return view('FuelRates::form')->with(compact('action','fuelRate'));
    }

}
