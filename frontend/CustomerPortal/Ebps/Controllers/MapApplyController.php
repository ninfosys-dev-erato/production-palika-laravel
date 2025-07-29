<?php


namespace Frontend\CustomerPortal\Ebps\Controllers;


use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Enums\FormPositionEnum;
use Src\Ebps\Models\DocumentFile;
use Src\Ebps\Models\MapApply;
use Src\Ebps\Models\MapApplyDetail;
use Src\Ebps\Models\MapApplyStep;
use Src\Ebps\Models\MapStep;
use Src\Ebps\Models\Organization;

class MapApplyController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:map_steps view')->only('index');
        //$this->middleware('permission:map_steps edit')->only('edit');
        //$this->middleware('permission:map_steps create')->only('create');
    }

    function index(Request $request){
        $organizations = Organization::whereNull('deleted_at')->get();
        return view('CustomerPortal.Ebps::map-applies-index', compact('organizations'));
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('CustomerPortal.Ebps::map-applies-form')->with(compact('action'));
    }

    function edit(Request $request){
        $mapApply = MapApply::find($request->route('id'));
        $action = Action::UPDATE;
        return view('CustomerPortal.Ebps::map-applies-form')->with(compact('action','mapApply'));
    }
    function show($id){
        $mapApply = MapApply::with([
            'fiscalYear',
            'landDetail.fourBoundaries',
            'landDetail.localBody',
            'constructionType',
        ])->where('id', $id)->first();

        $documents = DocumentFile::where('map_apply_id', $mapApply->id)->get();
        $mapApplyDetail = MapApplyDetail::with(['organization.localBody', 'organization.district'])->where('map_apply_id', $id)->first();

        $organization = $mapApplyDetail?->organization;
        return view('CustomerPortal.Ebps::map-applies-show')->with(compact('mapApply', 'documents', 'organization'));
    }

    function moveForward(int $id)
    {
        $mapStepsBefore = MapStep::whereNull('deleted_by')->where('form_position', FormPositionEnum::BEFORE_FILLING_APPLICATION)->get();
        $mapStepsAfter = MapStep::whereNull('deleted_by')->where('form_position', FormPositionEnum::AFTER_FILLING_APPLICATION)->get();
        $mapApply= MapApply::where('id', $id)->with('mapApplySteps')->first();
       
        return view('CustomerPortal.Ebps::steps', compact('mapStepsBefore', 'mapStepsAfter', 'mapApply'));
    }

    function mapApplyStep(MapStep $mapStep, MapApply $mapApply)
    {
        return view('CustomerPortal.Ebps::map-step-print', compact('mapStep', 'mapApply'));
    }

    public function previewMapStep(MapApplyStep $mapApplyStep)
    {
        return view('CustomerPortal.Ebps::preview', compact('mapApplyStep'));
    }

}
