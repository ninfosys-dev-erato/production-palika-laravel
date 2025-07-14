<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\MaterialType;

class MaterialTypeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:material_types view')->only('index');
        //$this->middleware('permission:material_types edit')->only('edit');
        //$this->middleware('permission:material_types create')->only('create');
    }

    function index(Request $request){
        return view('MaterialTypes::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('MaterialTypes::form')->with(compact('action'));
    }

    function edit(Request $request){
        $materialType = MaterialType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('MaterialTypes::form')->with(compact('action','materialType'));
    }

}
