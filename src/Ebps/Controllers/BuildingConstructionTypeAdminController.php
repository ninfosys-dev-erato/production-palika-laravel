<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\BuildingConstructionType;

class BuildingConstructionTypeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:building_construction_types view')->only('index');
        //$this->middleware('permission:building_construction_types edit')->only('edit');
        //$this->middleware('permission:building_construction_types create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::building-construction-type.building-construction-type-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::building-construction-type.building-construction-type-form')->with(compact('action'));
    }

    function edit(Request $request){
        $buildingConstructionType = BuildingConstructionType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::building-construction-type.building-construction-type-form')->with(compact('action','buildingConstructionType'));
    }

}
