<?php

namespace Src\BusinessRegistration\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\BusinessRegistration\Models\BusinessRenewalDocument;

class BusinessRenewalDocumentAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:business_renewals view')->only('index');
        //$this->middleware('permission:business_renewals edit')->only('edit');
        //$this->middleware('permission:business_renewals create')->only('create');
    }

    function index(Request $request)
    {
        return view('BusinessRegistration::business-renewal-documents.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('BusinessRegistration::business-renewal-documents.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $businessRenewalDocument = BusinessRenewalDocument::find($request->route('id'));
        $action = Action::UPDATE;
        return view('BusinessRegistration::business-renewal-documents.form')->with(compact('action', 'businessRenewalDocument'));
    }

}
