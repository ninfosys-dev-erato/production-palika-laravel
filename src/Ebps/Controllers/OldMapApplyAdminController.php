<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\DocumentFile;
use Src\Ebps\Models\MapApply;
use PDF;

class OldMapApplyAdminController extends Controller
{

    function index(Request $request)
    {
        return view('Ebps::old-application.old-application-index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ebps::old-application.old-application-form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $mapApply = MapApply::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::old-application.old-application-form')->with(compact('action', 'mapApply'));
    }

    function view($id)
    {
        $mapApply = MapApply::with(['fiscalYear', 'landDetail.fourBoundaries', 'landDetail.localBody', 'constructionType', 'houseOwner.province', 'houseOwner.district', 'houseOwner.localBody'])->findOrFail($id);
        $documents = DocumentFile::where('map_apply_id', $mapApply->id)->get();

        return view('Ebps::old-application.old-application-show')->with(compact('mapApply', 'documents'));

    }

    public function print($id)
    {
        try {
            $mapApply = MapApply::with(['fiscalYear', 'landDetail.fourBoundaries', 'landDetail.localBody', 'constructionType', 'houseOwner.province', 'houseOwner.district', 'houseOwner.localBody'])->findOrFail($id);
            $pdf = PDF::loadView('ebps.old_map_apply', compact('mapApply'));
            return $pdf->download('application-form.pdf');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
