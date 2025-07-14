<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\ConstructionType;

class ConstructionTypeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:construction_types view')->only('index');
        //$this->middleware('permission:construction_types edit')->only('edit');
        //$this->middleware('permission:construction_types create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::construction-type.construction-type-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::construction-type.construction-type-form')->with(compact('action'));
    }

    function edit(Request $request){
        $constructionType = ConstructionType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::construction-type.construction-type-form')->with(compact('action','constructionType'));
    }

}
