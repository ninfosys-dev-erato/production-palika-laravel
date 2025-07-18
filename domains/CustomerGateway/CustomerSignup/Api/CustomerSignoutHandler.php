<?php

namespace Domains\CustomerGateway\CustomerSignup\Api;
use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\CustomerSignup\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerSignoutHandler extends Controller
{
      use ApiStandardResponse;
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function logout(Request $request): JsonResponse
    {
        $result = $this->customerService->logout();

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 401);
        }

        return $this->generalSuccess(['message' => $result['message']]);

    }
}
