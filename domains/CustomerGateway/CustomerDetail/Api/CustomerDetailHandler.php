<?php

namespace Domains\CustomerGateway\CustomerDetail\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\CustomerDetail\Resources\ShowCustomerDetailsResource;
use Domains\CustomerGateway\CustomerDetail\Services\CustomerDetailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerDetailHandler extends Controller
{
    use ApiStandardResponse;
    protected $customerDetailService;

    public function __construct(CustomerDetailService $customerDetailService)
    {
        $this->customerDetailService = $customerDetailService;
    }
    
    public function show(Request $request): ShowCustomerDetailsResource
    {
        $customer = Auth::guard('api-customer')->user();        
        return new ShowCustomerDetailsResource($customer);
    }

    public function showNotificationPreference(Request $request): JsonResponse
    {
        $customer = Auth::guard('api-customer')->user();       
        
        return $this->generalSuccess([
            'notification_preference' => json_decode($customer->notification_preference, true),
        ]);
    }
}
