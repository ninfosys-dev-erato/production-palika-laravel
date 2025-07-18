<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\BuildingRoofType;

class BuildingRoofTypeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:building_roof_types view')->only('index');
        //$this->middleware('permission:building_roof_types edit')->only('edit');
        //$this->middleware('permission:building_roof_types create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::building-roof-type.building-roof-type-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::building-roof-type.building-roof-type-form')->with(compact('action'));
    }

    function edit(Request $request){
        $buildingRoofType = BuildingRoofType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::building-roof-type.building-roof-type-form')->with(compact('action','buildingRoofType'));
    }

}
