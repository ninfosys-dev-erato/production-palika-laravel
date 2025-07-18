<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\MapImportantDocument;

class MapImportantDocumentAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:map_important_documents view')->only('index');
        //$this->middleware('permission:map_important_documents edit')->only('edit');
        //$this->middleware('permission:map_important_documents create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::map-important-document.map-important-document-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::map-important-document.map-important-document-form')->with(compact('action'));
    }

    function edit(Request $request){
        $mapImportantDocument = MapImportantDocument::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::map-important-document.map-important-document-form')->with(compact('action','mapImportantDocument'));
    }

}
