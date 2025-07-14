<?php

namespace Src\Ebps\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ebps\Models\Document;

class DocumentAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:documents view')->only('index');
        //$this->middleware('permission:documents edit')->only('edit');
        //$this->middleware('permission:documents create')->only('create');
    }

    function index(Request $request){
        return view('Ebps::document.document-index');
    }

    function create(Request $request){
        $action = Action::CREATE;
        return view('Ebps::document.document-form')->with(compact('action'));
    }

    function edit(Request $request){
        $document = Document::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ebps::document.document.form')->with(compact('action','document'));
    }

}
