<?php

namespace Src\Ejalas\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\Ejalas\Models\RegistrationIndicator;

class RegistrationIndicatorAdminController extends Controller
{
    public function __construct()
    {
        //$this->middleware('permission:registration_indicators view')->only('index');
        //$this->middleware('permission:registration_indicators edit')->only('edit');
        //$this->middleware('permission:registration_indicators create')->only('create');
    }

    function index(Request $request)
    {
        return view('Ejalas::registration-indicator.index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Ejalas::registration-indicator.form')->with(compact('action'));
    }

    function edit(Request $request)
    {
        $registrationIndicator = RegistrationIndicator::find($request->route('id'));
        $action = Action::UPDATE;
        return view('Ejalas::registration-indicator.form')->with(compact('action', 'registrationIndicator'));
    }
}
