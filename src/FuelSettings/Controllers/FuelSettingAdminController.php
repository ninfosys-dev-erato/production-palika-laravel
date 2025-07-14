<?php

namespace Src\FuelSettings\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\FuelSettings\Models\FuelSetting;

class FuelSettingAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:fuel_settings view')->only('index');
        //$this->middleware('permission:fuel_settings edit')->only('edit');
        //$this->middleware('permission:fuel_settings create')->only('create');
    }
    public function dashboard()
    {
        return view('FuelSettings::dashboard');
    }
    function index(Request $request)
    {
        return view('FuelSettings::index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('FuelSettings::form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $fuelSetting = FuelSetting::find($request->route('id'));
        $action = Action::UPDATE;
        return view('FuelSettings::form')->with(compact('action', 'fuelSetting'));
    }
}
