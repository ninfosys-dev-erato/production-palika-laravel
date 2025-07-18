<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\EquipmentAdditionalCost;

class EquipmentAdditionalCostAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:equipment_additional_costs view')->only('index');
        //$this->middleware('permission:equipment_additional_costs edit')->only('edit');
        //$this->middleware('permission:equipment_additional_costs create')->only('create');
    }

    function index(Request $request){
        return view('equipment-additional-costs::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('equipment-additional-costs::form')->with(compact('action'));
    }

    function edit(Request $request){
        $equipmentAdditionalCost = EquipmentAdditionalCost::find($request->route('id'));
        $action = Action::UPDATE;
        return view('equipment-additional-costs::form')->with(compact('action','equipmentAdditionalCost'));
    }

}
