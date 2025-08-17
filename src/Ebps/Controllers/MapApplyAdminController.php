<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Enums\FormPositionEnum;
use Src\Ebps\Models\DocumentFile;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapApplyDetail;
use Src\Ebps\Models\MapApplyStep;
use Src\Ebps\Models\MapStep;
use PDF;

class MapApplyAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:map_applies view')->only('index');
        //$this->middleware('permission:map_applies edit')->only('edit');
        //$this->middleware('permission:map_applies create')->only('create');
    }

    function index(Request $request)
    {
        return view('Ebps::map-applies.map-applies-index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ebps::map-applies.map-applies-form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $mapApply = MapApply::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::map-applies.map-applies-form')->with(compact('action', 'mapApply'));
    }

    function view($id)
    {
        $mapApply = MapApply::with([
            'fiscalYear',
            'landDetail.fourBoundaries',
            'landDetail.localBody',
            'constructionType',
        ])->where('id', $id)->first();
        $documents = DocumentFile::where('map_apply_id', $mapApply->id)->get();

        $mapApplyDetail = MapApplyDetail::with(['organization.localBody', 'organization.district'])->where('map_apply_id', $id)->first();

        $organization = $mapApplyDetail?->organization;

        return view('Ebps::map-applies.map-applies-show')->with(compact('mapApply', 'documents', 'organization'));
    }

    function moveForward(int $id)
    {
        $mapStepsBefore = MapStep::with('form')->whereNull('deleted_by')->where('form_position', FormPositionEnum::BEFORE_FILLING_APPLICATION)->get();
        $mapStepsAfter = MapStep::whereNull('deleted_by')->where('form_position', FormPositionEnum::AFTER_FILLING_APPLICATION)->get();
        $mapApply = MapApply::where('id', $id)->with('mapApplySteps')->first();
        
        // Initialize role filter service for step access checks
        $roleFilterService = new \Src\Ebps\Service\ApplicationRoleFilterService();

        return view('Ebps::map-applies.map-applies-steps', compact('mapStepsBefore', 'mapStepsAfter', 'mapApply', 'roleFilterService'));
    }

    public function changeOwner(int $id)
    {
        $mapApply = MapApply::with([
            'fiscalYear',
            'landDetail.fourBoundaries',
            'landDetail.localBody',
            'constructionType'
        ])->findOrFail($id);

        return view('Ebps::change-owner')->with(compact('mapApply'));
    }
    public function showTemplate(int $houseOwnerId)
    {

        return view('Ebps::show-template')->with(compact('houseOwnerId'));
    }

    public function showOragnizationTemplate(int $organizationId, int $mapApplyId)
    {

        return view('Ebps::show-organization-template')->with(compact('organizationId', 'mapApplyId'));
    }

    public function changeOrganization(int $id)
    {
        $mapApply = MapApply::with([
            'fiscalYear',
            'landDetail.fourBoundaries',
            'landDetail.localBody',
            'constructionType'
        ])->findOrFail($id);

        return view('Ebps::change-organization')->with(compact('mapApply'));
    }

    function mapApplyStep(MapStep $mapStep, MapApply $mapApply)
    {
        return view('Ebps::map-applies.map-applies-print', compact('mapStep', 'mapApply'));
    }

    public function print($id)
    {
        try {
            $mapApply = MapApply::with([
                'fiscalYear',
                'landDetail.fourBoundaries',
                'landDetail.localBody',
                'constructionType'
            ])->find($id);

            // dd($mapApply); // <-- Dump and exit

            $pdf = PDF::loadView('ebps.map_apply', compact('mapApply'));
            return $pdf->download('application-form.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function previewMapStep(MapApplyStep $mapApplyStep)
    {
        return view('Ebps::map-applies.map-applies-preview', compact('mapApplyStep'));
    }
}
