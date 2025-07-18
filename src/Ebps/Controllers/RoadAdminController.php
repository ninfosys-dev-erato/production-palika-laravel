<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\Road;

class RoadAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:roads view')->only('index');
        //$this->middleware('permission:roads edit')->only('edit');
        //$this->middleware('permission:roads create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::road.road-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::road.road-form')->with(compact('action'));
    }

    function edit(Request $request){
        $road = Road::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::road.road-form')->with(compact('action','road'));
    }

}
