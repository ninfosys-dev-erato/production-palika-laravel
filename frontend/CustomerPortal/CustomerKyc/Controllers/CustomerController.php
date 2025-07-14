<?php

namespace Frontend\CustomerPortal\CustomerKyc\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Src\CustomerKyc\Model\CustomerKycVerificationLog;
use Src\Customers\Models\Customer;

class CustomerController extends Controller
{
    use ApiStandardResponse;

    function index(Request $request)
    {
        $customer = Customer::where( 'id', Auth::guard('customer')->id())->first();
            return view('CustomerPortal.CustomerKyc::customerKyc-show')->with(compact( 'customer'));
    }

    function create(Request $request)
    {
        $customer = Customer::where( 'id', Auth::guard('customer')->id())->with('kyc')->first();
        $action = Action::UPDATE;
        return view( 'CustomerPortal.CustomerKyc::customerKyc-form')->with(compact('action', 'customer'));
    }

}
