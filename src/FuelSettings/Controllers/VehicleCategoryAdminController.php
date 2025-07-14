<?php

namespace Src\FuelSettings\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\FuelSettings\Models\VehicleCategory;

class VehicleCategoryAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:vehicle_categories view')->only('index');
        //$this->middleware('permission:vehicle_categories edit')->only('edit');
        //$this->middleware('permission:vehicle_categories create')->only('create');
    }

    function index(Request $request)
    {
        return view('FuelSettings::vehicle-category.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('FuelSettings::vehicle-category.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $vehicleCategory = VehicleCategory::find($request->route('id'));
        $action = Action::UPDATE;
        return view('FuelSettings::vehicle-category.form')->with(compact('action', 'vehicleCategory'));
    }
}
