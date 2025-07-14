<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\StructureType;

class StructureTypeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:structure_types view')->only('index');
        //$this->middleware('permission:structure_types edit')->only('edit');
        //$this->middleware('permission:structure_types create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::structure-type.structure-type-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::structure-type.structure-type-form')->with(compact('action'));
    }

    function edit(Request $request){
        $structureType = StructureType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::structure-type.structure-type-form')->with(compact('action','structureType'));
    }

}
