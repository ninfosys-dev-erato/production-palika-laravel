<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\CollectionResource;

class CollectionResourceAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:collection_resources view')->only('index');
        //$this->middleware('permission:collection_resources edit')->only('edit');
        //$this->middleware('permission:collection_resources create')->only('create');
    }

    function index(Request $request){
        return view('CollectionResources::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('CollectionResources::form')->with(compact('action'));
    }

    function edit(Request $request){
        $collectionResource = CollectionResource::find($request->route('id'));
        $action = Action::UPDATE;
        return view('CollectionResources::form')->with(compact('action','collectionResource'));
    }

}
