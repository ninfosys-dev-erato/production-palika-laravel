<?php

namespace Src\BusinessRegistration\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\BusinessRegistration\Enums\BusinessRegistrationType;
use Src\BusinessRegistration\Models\BusinessDeRegistration;
use Src\BusinessRegistration\Models\BusinessRegistration;
use Src\BusinessRegistration\Models\RegistrationType;
use Src\BusinessRegistration\Traits\BusinessRegistrationTemplate;

class BusinessDeRegistrationAdminController extends Controller implements HasMiddleware
{
    use BusinessRegistrationTemplate;
    public static function middleware()
    {
        return [
            new Middleware('permission:business_registration access', only: ['index']),
            new Middleware('permission:business_registration create', only: ['create']),
            new Middleware('permission:business_registration update', only: ['edit']),
        ];
    }

    public function index(Request $request)
    {
        // $type = $request->query('type');
        $type = $request->query('type') ?? BusinessRegistrationType::DEREGISTRATION->value;


        return view('BusinessRegistration::business-deregistration.index')->with(compact('type'));
    }

    public function create(Request $request, RegistrationType $registration)
    {
        $businessRegistrationType = BusinessRegistrationType::from($request->query('type'));
        $action = Action::CREATE;
        return view('BusinessRegistration::business-deregistration.form')->with(compact('registration', 'businessRegistrationType', 'action'));
    }
    public function edit(Request $request, $id)
    {
        $businessDeRegistration = BusinessDeRegistration::find($request->route('id'));
        $businessRegistrationType = BusinessRegistrationType::from($request->query('type'));
        $action = Action::UPDATE;
        return view('BusinessRegistration::business-deregistration.form')->with(compact('businessDeRegistration', 'businessRegistrationType', 'action'));
    }
    public function view(Request $request, $id) {}
    public function preview(Request $request, $id) {}
}
