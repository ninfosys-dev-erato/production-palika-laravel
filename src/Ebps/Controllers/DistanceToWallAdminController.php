<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\DistanceToWall;

class DistanceToWallAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:distance_to_walls view')->only('index');
        //$this->middleware('permission:distance_to_walls edit')->only('edit');
        //$this->middleware('permission:distance_to_walls create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::distance-to-wall.distance-to-wall-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::distance-to-wall.distance-to-wall-form')->with(compact('action'));
    }

    function edit(Request $request){
        $distanceToWall = DistanceToWall::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::distance-to-wall.distance-to-wall-form')->with(compact('action','distanceToWall'));
    }

}
