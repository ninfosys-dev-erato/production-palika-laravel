<?php

namespace Src\FuelSettings\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\FuelSettings\Models\Vehicle;

class VehicleAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:vehicles view')->only('index');
        //$this->middleware('permission:fms_vehicles edit')->only('edit');
        //$this->middleware('permission:fms_vehicles create')->only('create');
    }

    function index(Request $request)
    {
        return view('FuelSettings::vehicle.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('FuelSettings::vehicle.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $vehicle = Vehicle::find($request->route('id'));
        $action = Action::UPDATE;
        return view('FuelSettings::vehicle.form')->with(compact('action', 'vehicle'));
    }
}
