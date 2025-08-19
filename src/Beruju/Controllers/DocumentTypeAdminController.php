<?php

namespace Src\Beruju\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Beruju\Models\DocumentType;

class DocumentTypeAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:document-types view')->only('index');
        //$this->middleware('permission:document-types edit')->only('edit');
        //$this->middleware('permission:document-types create')->only('create');
    }

    function index(Request $request)
    {
        return view('Beruju::document-types.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Beruju::document-types.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $documentType = DocumentType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Beruju::document-types.form')->with(compact('action', 'documentType'));
    }

    function show(Request $request)
    {
        $documentType = DocumentType::with(['creator', 'updater'])->findOrFail($request->route('id'));
        return view('Beruju::document-types.show')->with(compact('documentType'));
    }
}
