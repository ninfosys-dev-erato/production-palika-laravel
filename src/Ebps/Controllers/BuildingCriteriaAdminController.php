<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Models\BuildingCriteria;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapStep;

class BuildingCriteriaAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:building_criterias view')->only('index');
        //$this->middleware('permission:building_criterias edit')->only('edit');
        //$this->middleware('permission:building_criterias create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::building-criterias.building-criterias-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::building-criterias.building-criterias-form')->with(compact('action'));
    }

    function edit(Request $request){
        $buildingCriteria = BuildingCriteria::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::building-criterias.building-criterias-form')->with(compact('action','buildingCriteria'));
    }

}
