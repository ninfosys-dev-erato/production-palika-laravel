<?php

namespace Domains\CustomerGateway\CustomerDetail\Services;
use Illuminate\Support\Facades\Auth;
use Src\Customers\Models\Customer;
use Src\Customers\Service\CustomerServices;

class CustomerDetailService
{
    protected $customerService;

    public function __construct(CustomerServices $customerService)
    {
        $this->customerService = $customerService;
    }
    public function avatar($data)
    {
        $user = Auth::guard('api-customer')->user();
        return $this->customerService->avatar($data, $user);

    }
}