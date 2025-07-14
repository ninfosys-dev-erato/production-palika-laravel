<?php

namespace Frontend\BusinessPortal\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Models\BuildingConstructionType;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapApplyStep;
use Src\Ebps\Models\MapStep;

class BuildingRegistrationController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:building_construction_types view')->only('index');
        //$this->middleware('permission:building_construction_types edit')->only('edit');
        //$this->middleware('permission:building_construction_types create')->only('create');
    }

    function index(Request $request){
       
        return view('BusinessPortal.Ebps::building-registration-index');
    }

    

    function create(Request $request){
        $action = Action::CREATE;
        return view('BusinessPortal.Ebps::building-registration-form')->with(compact('action'));
    }

    function edit(Request $request){
        $mapApply = MapApply::find($request->route('id'));
     
        $action = Action::UPDATE;
        return view('BusinessPortal.Ebps::building-registration-form')->with(compact('action','mapApply'));
    }

    function moveForward(int $id)
    {
        $steps = MapStep::whereNull('deleted_by')->where('application_type', ApplicationTypeEnum::BUILDING_DOCUMENTATION )->get();
        $mapApply= MapApply::where('id', $id)->with('mapApplySteps')->first();
       
        return view('BusinessPortal.Ebps::building-registration-steps', compact('steps',  'mapApply'));
    }

    function mapApplyStep(MapStep $mapStep, MapApply $mapApply)
    {
        return view('BusinessPortal.Ebps::building-registration-apply', compact('mapStep', 'mapApply'));
    }

    public function previewMapStep(MapApplyStep $mapApplyStep)
    {
          return view('BusinessPortal.Ebps::preview', compact('mapApplyStep'));
    }

    function show($id)
    {
        $mapApply = MapApply::with([
            'fiscalYear', 
            'landDetail.fourBoundaries', 
            'landDetail.localBody', 
            'constructionType', 
            'houseOwner.province', 
            'houseOwner.district', 
            'houseOwner.localBody', 
            'landOwner.province',
            'landOwner.district',
            'landOwner.localBody',
            'province',
            'district', 
            'localBody','detail',
            'landDetail',
            'buildingConstructionType',
            'fiscalYear',
            'mapApplySteps',
            'storeyDetails.storey',
            'distanceToWalls',
            'roads',
            'cantileverDetails',
            'highTensionLineDetails',
            'buildingRoofType'
        ])->findOrFail($id);

        return view('BusinessPortal.Ebps::building-registration-show')->with(compact('mapApply'));

    }

}
