<?php

namespace Src\Customers\Controllers;

use App\Enums\Action;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Src\CustomerKyc\Model\CustomerKycVerificationLog;
use Src\Customers\Models\Customer;

class CustomerController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:customer access', only: ['index']),
        ];
    }

    function index(Request $request)
    {
        return view('Customers::customer_index');
    }

    function create(Request $request)
    {
        $action = Action::CREATE;
        return view('Customers::customer_form')->with(compact('action'));
    }

    public function show(int $id)
    {
        $customer = Customer::with([
            'kyc.permanentProvince',
            'kyc.permanentDistrict',
            'kyc.permanentLocalBody',
            'kyc.temporaryProvince',
            'kyc.temporaryDistrict',
            'kyc.temporaryLocalBody',
            'kyc.citizenshipIssueDistrict',
        ])->findOrFail($id);

        $kycLogs = CustomerKycVerificationLog::where('customer_id', $id)->orderBy('created_at', 'desc')->get();
        return view('Customers::customer_show', compact('customer', 'kycLogs'));
    }
}
