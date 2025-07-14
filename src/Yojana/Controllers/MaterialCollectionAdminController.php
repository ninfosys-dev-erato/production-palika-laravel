<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\MaterialCollection;

class MaterialCollectionAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:material_collections view')->only('index');
        //$this->middleware('permission:material_collections edit')->only('edit');
        //$this->middleware('permission:material_collections create')->only('create');
    }

    function index(Request $request){
        return view('MaterialCollections::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('MaterialCollections::form')->with(compact('action'));
    }

    function edit(Request $request){
        $materialCollection = MaterialCollection::find($request->route('id'));
        $action = Action::UPDATE;
        return view('MaterialCollections::form')->with(compact('action','materialCollection'));
    }

}
