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
            new Middleware('permission:business-registration_access', only: ['index']),
            new Middleware('permission:business-registration_create', only: ['create']),
            new Middleware('permission:business-registration_update', only: ['edit']),
        ];
    }

    public function index(Request $request)
    {
        // $type = $request->query('type');
        $type = $request->query('type') ?? BusinessRegistrationType::REGISTRATION->value;

        return view('BusinessRegistration::business-registration.index')->with(compact('type'));
    }

    public function create(Request $request, RegistrationType $registration)
    {
        $businessRegistrationType = BusinessRegistrationType::from($request->query('type'));
        $action = Action::CREATE;
        return view('BusinessRegistration::business-registration.form')->with(compact('action', 'registration', 'businessRegistrationType'));
    }

    public function edit(Request $request)
    {
        $businessRegistration = BusinessRegistration::find($request->route('id'));
        $businessRegistrationType = $request->query('type');
        $businessRegistration->data = json_decode($businessRegistration->data, true, 512);
        $action = Action::UPDATE;
        $businessRegistrationType = $businessRegistration->registration_type ?? BusinessRegistrationType::REGISTRATION;

        return view('BusinessRegistration::business-registration.form')->with(compact('action', 'businessRegistration', 'businessRegistrationType'));
    }

    public function view(Request $request)
    {
        $businessRegistration = BusinessRegistration::findOrFail($request->route('id'));
        $template = $this->resolveTemplate($businessRegistration);
        return view('BusinessRegistration::business-registration.show')->with(compact('businessRegistration', 'template'));
    }

    public function preview($id)
    {
        $businessRegistration = BusinessRegistration::where('id', $id)->first();
        return view('BusinessRegistration::business-registration.preview')->with(compact('businessRegistration'));
    }
}
