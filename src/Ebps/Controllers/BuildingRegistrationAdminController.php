<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Models\BuildingConstructionType;
use Src\Ebps\Models\DocumentFile;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapApplyStep;
use Src\Ebps\Models\MapStep;
use PDF;

class BuildingRegistrationAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:building_construction_types view')->only('index');
        //$this->middleware('permission:building_construction_types edit')->only('edit');
        //$this->middleware('permission:building_construction_types create')->only('create');
    }

    function index(Request $request)
    {

        return view('Ebps::building-registration.building-registration-index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ebps::building-registration.building-registration-form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $mapApply = MapApply::find($request->route('id'));

        $action = Action::UPDATE;
        return view('Ebps::building-registration.building-registration-form')->with(compact('action', 'mapApply'));
    }

    function moveForward(int $id)
    {
        $steps = MapStep::with('form')->whereNull('deleted_by')->where('application_type', ApplicationTypeEnum::BUILDING_DOCUMENTATION)->get();
        $mapApply = MapApply::where('id', $id)->with('mapApplySteps')->first();

        return view('Ebps::building-registration.building-registration-steps', compact('steps', 'mapApply'));
    }

    function mapApplyStep(MapStep $mapStep, MapApply $mapApply)
    {
        return view('Ebps::building-registration.building-registration-apply', compact('mapStep', 'mapApply'));
    }

    public function previewMapStep(MapApplyStep $mapApplyStep)
    {
        return view('Ebps::building-registration.building-registration-preview', compact('mapApplyStep'));
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
            'localBody',
            'detail',
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

        $documents = DocumentFile::where('map_apply_id', $mapApply->id)->get();

        return view('Ebps::building-registration.building-registration-show')->with(compact('mapApply', 'documents'));

    }

    public function print($id)
    {
        try {
            $mapApply = MapApply::with(
                [
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
                    'localBody',
                    'detail',
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
                ]
            )->findOrFail($id);


            $pdf = PDF::loadView('ebps.business_registration', compact('mapApply'));
            return $pdf->download('application-form.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
