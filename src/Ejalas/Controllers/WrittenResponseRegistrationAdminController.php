<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\WrittenResponseRegistration;

class WrittenResponseRegistrationAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:written_response_registrations view')->only('index');
        //$this->middleware('permission:written_response_registrations edit')->only('edit');
        //$this->middleware('permission:written_response_registrations create')->only('create');
    }
    function index(Request $request)
    {
        return view('Ejalas::written-response-registration.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ejalas::written-response-registration.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $writtenResponseRegistration = WrittenResponseRegistration::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::written-response-registration.form')->with(compact('action', 'writtenResponseRegistration'));
    }
    function preview(Request $request)
    {
        $writtenResponseRegistration = WrittenResponseRegistration::findOrFail($request->route('id'));
        return view('Ejalas::written-response-registration.preview', compact('writtenResponseRegistration'));
    }
}
