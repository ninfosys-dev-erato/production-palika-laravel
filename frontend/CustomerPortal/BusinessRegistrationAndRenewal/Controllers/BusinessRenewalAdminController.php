<?php

namespace Frontend\CustomerPortal\BusinessRegistrationAndRenewal\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\BusinessRegistration\Models\BusinessRenewal;

class BusinessRenewalAdminController extends Controller
{

    function index(Request $request)
    {
        return view('CustomerPortal.BusinessRegistrationAndRenewal::renewal.index');
    }

    public function view(Request $request)
    {
        $businessRenewal = BusinessRenewal::with('registration')->findOrFail($request->route('id'));
        return view('CustomerPortal.BusinessRegistrationAndRenewal::renewal.show')->with(compact('businessRenewal'));
    }
}
