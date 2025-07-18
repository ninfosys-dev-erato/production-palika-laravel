<?php

namespace Src\BusinessRegistration\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\BusinessRegistration\Models\RegistrationType;

class RegistrationTypeAdminController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:business_registration access', only: ['index']),
            new Middleware('permission:business_registration create', only: ['create']),
            new Middleware('permission:business_registration edit', only: ['edit']),
        ];
    }

    public function index()
    {
        return view('BusinessRegistration::registration-types.index');
    }

    public function create(Request $request)
    {
        $action = Action::CREATE;
        return view('BusinessRegistration::registration-types.form')->with(compact('action'));
    }

    public function edit(Request $request)
    {
        $registrationType = RegistrationType::find($request->route('id'));
        $action = Action::UPDATE;
        return view('BusinessRegistration::registration-types.form')->with(compact('action', 'registrationType'));
    }
}
