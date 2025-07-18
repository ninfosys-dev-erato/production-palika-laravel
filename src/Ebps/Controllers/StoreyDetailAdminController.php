<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\StoreyDetail;

class StoreyDetailAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:storey_details view')->only('index');
        //$this->middleware('permission:storey_details edit')->only('edit');
        //$this->middleware('permission:storey_details create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::storey-detail.storey-detail-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::storey-detail.storey-detail-form')->with(compact('action'));
    }

    function edit(Request $request){
        $storeyDetail = StoreyDetail::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::storey-detail.storey-detail-form')->with(compact('action','storeyDetail'));
    }

}
