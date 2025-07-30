<?php

namespace Src\BusinessRegistration\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use App\Traits\HelperDate;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\BusinessRegistration\Enums\BusinessRegistrationType;
use Src\BusinessRegistration\Models\BusinessRenewal;

class BusinessRenewalAdminController extends Controller implements HasMiddleware
{
    use HelperDate;
    public static function middleware(): array
    {
        return [
            new Middleware('permission:business_renewals access', only: ['index']),
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
        $action = Action::CREATE;
        return view('BusinessRegistration::renewal.form')->with(compact('action'));
    }

    function edit(Request $request)
    {

        $businessRenewal = BusinessRenewal::find($request->route('id'));
        $action = Action::UPDATE;
        return view('BusinessRegistration::renewal.form')->with(compact('action', 'businessRenewal'));
    }

    public function view(Request $request)
    {
        $businessRenewal = BusinessRenewal::with([
            'registration',
            'registration.registrationType',
            'registration.registrationType.registrationCategory',
            'registration.applicants',
            'registration.applicants.applicantProvince',
            'registration.applicants.applicantDistrict',
            'registration.applicants.applicantLocalBody',
            'registration.applicants.citizenshipDistrict',
            'registration.requiredBusinessDocs',
            'fiscalYear'
        ])->findOrFail($request->route('id'));

        return view('BusinessRegistration::renewal.show')->with(compact('businessRenewal'));
    }
}
