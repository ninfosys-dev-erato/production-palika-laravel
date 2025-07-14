<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\MapStep;

class MapStepAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:map_steps view')->only('index');
        //$this->middleware('permission:map_steps edit')->only('edit');
        //$this->middleware('permission:map_steps create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::map-step.map-step-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::map-step.map-step-form')->with(compact('action'));
    }

    function edit(Request $request){
        $mapStep = MapStep::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::map-step.map-step-form')->with(compact('action','mapStep'));
    }

}
