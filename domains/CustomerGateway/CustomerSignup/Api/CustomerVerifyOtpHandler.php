<?php

namespace Domains\CustomerGateway\CustomerSignup\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\CustomerSignup\DTO\CustomerVerifyOtpDto;
use Domains\CustomerGateway\CustomerSignup\Requests\CustomerVerifyOtpRequest;
use Domains\CustomerGateway\CustomerSignup\Services\CustomerService;
use Illuminate\Http\JsonResponse;

class CustomerVerifyOtpHandler extends Controller
{
    use ApiStandardResponse;
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function verifyOtp(CustomerVerifyOtpRequest $request): JsonResponse
    {
        $data =$request->validated();

        $dto = CustomerVerifyOtpDto::fromValidatedRequest($data);

        $result = $this->customerService->verifyOtp(['token' => decrypt($dto->token), 'otp' => $dto->otp]);

        if ($result['success']) {
            return $this->generalSuccess(['message' => $result['message']]);
        }
        return $this->generalFailure(['message' => $result['message']]);
    }

}
