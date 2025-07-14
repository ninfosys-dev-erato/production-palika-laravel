<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\MapPassGroup;

class MapPassGroupAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:map_pass_groups view')->only('index');
        //$this->middleware('permission:map_pass_groups edit')->only('edit');
        //$this->middleware('permission:map_pass_groups create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::map-pass-group.map-pass-group-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::map-pass-group.map-pass-group-form')->with(compact('action'));
    }

    function edit(Request $request){
        $mapPassGroup = MapPassGroup::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::map-pass-group.map-pass-group-form')->with(compact('action','mapPassGroup'));
    }

}
