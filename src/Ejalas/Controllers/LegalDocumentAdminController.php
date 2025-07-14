<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\LegalDocument;

class LegalDocumentAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:legal_documents view')->only('index');
        //$this->middleware('permission:legal_documents edit')->only('edit');
        //$this->middleware('permission:legal_documents create')->only('create');
    }

    function index(Request $request)
    {
        return view('Ejalas::legal-document.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ejalas::legal-document.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $legalDocument = LegalDocument::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::legal-document.form')->with(compact('action', 'legalDocument'));
    }
    function preview(Request $request)
    {
        $legalDocument = LegalDocument::find($request->route('id'));
        return view('Ejalas::legal-document.preview', compact('legalDocument'));
    }
}
