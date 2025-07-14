<?php

namespace Src\Yojana\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Yojana\Models\ProjectDocument;

class ProjectDocumentAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:project_documents view')->only('index');
        //$this->middleware('permission:project_documents edit')->only('edit');
        //$this->middleware('permission:project_documents create')->only('create');
    }

    function index(Request $request){
        return view('ProjectDocuments::index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('ProjectDocuments::form')->with(compact('action'));
    }

    function edit(Request $request){
        $projectDocument = ProjectDocument::find($request->route('id'));
        $action = Action::UPDATE;
        return view('ProjectDocuments::form')->with(compact('action','projectDocument'));
    }

}
