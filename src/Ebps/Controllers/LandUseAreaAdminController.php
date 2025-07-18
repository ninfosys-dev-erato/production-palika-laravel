<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\LandUseArea;

class LandUseAreaAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:land_use_areas view')->only('index');
        //$this->middleware('permission:land_use_areas edit')->only('edit');
        //$this->middleware('permission:land_use_areas create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::land-use-area.land-use-area-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::land-use-area.land-use-area-form')->with(compact('action'));
    }

    function edit(Request $request){
        $landUseArea = LandUseArea::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::land-use-area.land-use-area-form')->with(compact('action','landUseArea'));
    }

}
