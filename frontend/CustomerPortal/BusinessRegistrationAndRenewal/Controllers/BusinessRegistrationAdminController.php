<?php

namespace Frontend\CustomerPortal\BusinessRegistrationAndRenewal\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\BusinessRegistration\Enums\BusinessRegistrationType;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Models\RegistrationType;
use Src\BusinessRegistration\Traits\BusinessRegistrationTemplate;
use Illuminate\Support\Facades\Auth;

class BusinessRegistrationAdminController extends Controller
{
    use BusinessRegistrationTemplate;


    public function index(Request $request)
    {
        $type = $request->query('type');
        try {
            $type = BusinessRegistrationType::from($type);
        } catch (\ValueError $e) {
            $type = BusinessRegistrationType::REGISTRATION;
        }

        return view('CustomerPortal.BusinessRegistrationAndRenewal::business-registration.index')->with(compact('type'));
    }

    public function create(Request $request, RegistrationType $registration)
    {
        $businessRegistrationType = BusinessRegistrationType::tryFrom($request->query('type'))
            ?? BusinessRegistrationType::REGISTRATION;
        $action = Action::CREATE;
        return view('CustomerPortal.BusinessRegistrationAndRenewal::business-registration.form')->with(compact('action', 'registration', 'businessRegistrationType'));
    }
    public function edit(Request $request)
    {
        $businessRegistration = BusinessRegistration::find($request->route('id'));
        $businessRegistrationType = $request->query('type');
        $businessRegistration->data = json_decode($businessRegistration->data, true, 512);
        $action = Action::UPDATE;
        $businessRegistrationType = BusinessRegistrationType::tryFrom($request->query('type'))
            ?? BusinessRegistrationType::REGISTRATION;


        return view('CustomerPortal.BusinessRegistrationAndRenewal::business-registration.form')->with(compact('action', 'businessRegistration', 'businessRegistrationType'));
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


        $template = $this->resolveTemplate($businessRegistration);
        //uses the same view as of admin to reduce redundant code
        return view('BusinessRegistration::business-registration.show')->with(compact('businessRegistration', 'template'));
    }

    public function preview($id)
    {
        $businessRegistration = BusinessRegistration::where('id', $id)->first();
        return view('BusinessRegistration::business-registration.preview')->with(compact('businessRegistration'));
    }
}
