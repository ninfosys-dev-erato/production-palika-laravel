<?php

namespace Src\BusinessRegistration\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\BusinessRegistration\Enums\BusinessRegistrationType;
use Src\BusinessRegistration\Models\BusinessRenewal;

class BusinessRenewalAdminController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:business-registration-renewal_access', only: ['index']),
            new Middleware('permission:business_renewals create', only: ['create']),
            new Middleware('permission:business_renewals edit', only: ['edit']),
        ];
    }

    function index(Request $request)
    {
        $type = $request->query('type') ?? BusinessRegistrationType::REGISTRATION->value;
        return view('BusinessRegistration::renewal.index')->with(compact('type'));
    }

    function create(Request $request)
    {
        $businessRegistrationType = BusinessRegistrationType::from($request->query('type'));
        $action = Action::CREATE;
        return view('BusinessRegistration::renewal.form')->with(compact('action', 'businessRegistrationType'));
    }

    function edit(Request $request)
    {
        $businessRegistrationType = $request->query('type');
        $businessRenewal = BusinessRenewal::find($request->route('id'));
        $action = Action::UPDATE;
        return view('BusinessRegistration::renewal.form')->with(compact('action', 'businessRenewal', 'businessRegistrationType'));
    }

    public function view(Request $request)
    {
        $businessRenewal = BusinessRenewal::with('registration')->findOrFail($request->route('id'));
        return view('BusinessRegistration::renewal.show')->with(compact('businessRenewal'));
    }
}
