<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\MapApplyDetail;

class MapApplyDetailAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:map_apply_details view')->only('index');
        //$this->middleware('permission:map_apply_details edit')->only('edit');
        //$this->middleware('permission:map_apply_details create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::map-apply-detail.map-apply-detail-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::map-apply-detail.map-apply-detail-form')->with(compact('action'));
    }

    function edit(Request $request){
        $mapApplyDetail = MapApplyDetail::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::map-apply-detail.map-apply-detail-form')->with(compact('action','mapApplyDetail'));
    }

}
