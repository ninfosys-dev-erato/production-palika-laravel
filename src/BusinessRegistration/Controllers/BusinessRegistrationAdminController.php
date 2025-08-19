<?php

namespace Src\BusinessRegistration\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\BusinessRegistration\Enums\BusinessRegistrationType;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Models\RegistrationType;
use Src\BusinessRegistration\Traits\BusinessRegistrationTemplate;

class BusinessRegistrationAdminController extends Controller implements HasMiddleware
{
    use BusinessRegistrationTemplate;
    public static function middleware()
    {
        return [
            new Middleware('permission:business_registration access', only: ['index']),
            new Middleware('permission:business_registration create', only: ['create']),
            new Middleware('permission:business_registration edit', only: ['edit']),
        ];
    }

    public function index(Request $request)
    {
        // $type = $request->query('type');
        $type = $request->query('type');
        try {
            $type = BusinessRegistrationType::from($type);
        } catch (\ValueError $e) {
            $type = BusinessRegistrationType::REGISTRATION;
        }

        return view('BusinessRegistration::business-registration.index')->with(compact('type'));
    }

    public function create(Request $request, RegistrationType $registration)
    {
        $businessRegistrationType = BusinessRegistrationType::tryFrom($request->query('type'))
            ?? BusinessRegistrationType::REGISTRATION;
        $action = Action::CREATE;
        return view('BusinessRegistration::business-registration.form')->with(compact('action', 'registration', 'businessRegistrationType'));
    }

    public function edit(Request $request)
    {
        $businessRegistration = BusinessRegistration::find($request->route('id'));
        $businessRegistrationType = $request->query('type');
        $businessRegistration->data = json_decode($businessRegistration->data, true, 512);
        $action = Action::UPDATE;
        $businessRegistrationType = BusinessRegistrationType::tryFrom($request->query('type'))
            ?? BusinessRegistrationType::REGISTRATION;

        return view('BusinessRegistration::business-registration.form')->with(compact('action', 'businessRegistration', 'businessRegistrationType'));
    }

    public function view(Request $request)
    {
        $businessRegistration = BusinessRegistration::with([
            'fiscalYear',
            'businessProvince',
            'businessDistrict',
            'businessLocalBody',
            'applicants',
            'applicants.applicantProvince',
            'applicants.applicantDistrict',
            'applicants.applicantLocalBody',
            'applicants.citizenshipDistrict',
            'requiredBusinessDocs',
        ])->findOrFail($request->route('id'));

        $type = $request->query('type');
        try {
            $type = BusinessRegistrationType::from($type);
        } catch (\ValueError $e) {
            $type = BusinessRegistrationType::REGISTRATION;
        }

        $template = $this->resolveTemplate($businessRegistration);
        return view('BusinessRegistration::business-registration.show')->with(compact('businessRegistration', 'template', 'type'));
    }

    public function preview(Request $request)
    {
        $businessRegistration = BusinessRegistration::where('id', $request->route('id'))->first();

        $type = $request->query('type');
        try {
            $type = BusinessRegistrationType::from($type);
        } catch (\ValueError $e) {
            $type = BusinessRegistrationType::REGISTRATION;
        }

        return view('BusinessRegistration::business-registration.preview')->with(compact('businessRegistration', 'type'));
    }
}
