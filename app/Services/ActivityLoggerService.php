<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Facades\CauserResolver;

class ActivityLoggerService
{
    public function logForCustomer() : void
    {
        $customer = Auth::guard('customer')->user();
        CauserResolver::setCauser($customer);
    }

    public function logForCustomerApi()
    {
        $customer = Auth::guard('api-customer')->user();
        CauserResolver::setCauser($customer);
    }

}