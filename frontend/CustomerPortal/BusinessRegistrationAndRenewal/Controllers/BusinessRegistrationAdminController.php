<?php

namespace Frontend\CustomerPortal\BusinessRegistrationAndRenewal\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Traits\BusinessRegistrationTemplate;

class BusinessRegistrationAdminController extends Controller
{
    use BusinessRegistrationTemplate;

    public function index()
    {
        return view('CustomerPortal.BusinessRegistrationAndRenewal::business-registration.index');
    }

    public function create(Request $request)
    {
        $action = Action::CREATE;
        return view('CustomerPortal.BusinessRegistrationAndRenewal::business-registration.form')->with(compact('action'));
    }

    public function edit(Request $request)
    {
        $businessRegistration = BusinessRegistration::find($request->route('id'));
        $businessRegistration->data = json_decode($businessRegistration->data, true, 512);
        $action = Action::UPDATE;
        return view('CustomerPortal.BusinessRegistrationAndRenewal::business-registration.form')->with(compact('action', 'businessRegistration'));
    }

    public function view(Request $request)
    {
        $businessRegistration = BusinessRegistration::findOrFail($request->route('id'));
        $template = $this->resolveTemplate($businessRegistration);
        return view('CustomerPortal.BusinessRegistrationAndRenewal::business-registration.show')->with(compact('businessRegistration', 'template'));
    }
}
