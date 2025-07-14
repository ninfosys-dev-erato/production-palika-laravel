<?php

namespace Domains\CustomerGateway\CustomerSignup\Api;
use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\CustomerSignup\Requests\CustomerNotificationPreferenceRequest;
use Domains\CustomerGateway\CustomerSignup\Services\CustomerService;
use Illuminate\Http\JsonResponse;

class CustomerNotificationPreferenceHandler extends Controller
{
    use ApiStandardResponse;

    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function setNotification(CustomerNotificationPreferenceRequest $request): JsonResponse
    {
        $data = $request->validated();

        $this->customerService->setNotification($data);
        return $this->generalSuccess([ 'message' => __('Notification preference has been set .'),]);
    }
}