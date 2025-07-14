<?php

namespace Domains\CustomerGateway\CustomerKyc\Services;

use Illuminate\Support\Facades\Auth;
use Src\CustomerKyc\Services\CustomerKycService;

class DomainCustomerKycService
{
    protected $customerKycService;
    protected $customer;

    public function __construct(CustomerKycService $customerKycService)
    {
        $this->customerKycService = $customerKycService;
        $this->customer = Auth::guard('api-customer')->user();
    }

    public function store($data): void
    {
         $this->customerKycService->storeCustomerKyc($data, $this->customer);
    }
    public function update($data): void
    {
        $this->customerKycService->updateCustomerKyc($data, $this->customer);
    }
}