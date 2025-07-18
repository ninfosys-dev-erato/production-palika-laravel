<?php

namespace Frontend\CustomerPortal\DartaChalani\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Src\BusinessRegistration\Models\BusinessRegistration;

class DartaChalaniController extends Controller
{

    public function index()
    {
        return view('CustomerPortal.DartaChalani::index');
    }

  

    // public function view(Request $request)
    // {
    //     $businessRegistration = BusinessRegistration::findOrFail($request->route('id'));
    //     return view('CustomerPortal.BusinessRegistrationAndRenewal::business-registration.show')->with(compact('businessRegistration'));
    // }
}
