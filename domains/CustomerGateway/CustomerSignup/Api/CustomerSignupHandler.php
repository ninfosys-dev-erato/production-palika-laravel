<?php

namespace Domains\CustomerGateway\CustomerSignup\Api;

use App\Enums\OtpPurpose;
use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\CustomerSignup\DTO\CustomerSignUpDto;
use Domains\CustomerGateway\CustomerSignup\Requests\CustomerSignUpRequest;
use Domains\CustomerGateway\CustomerSignup\Services\CustomerService;
use Illuminate\Http\JsonResponse;

class CustomerSignupHandler extends Controller
{
    use ApiStandardResponse;
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function register(CustomerSignUpRequest $request): JsonResponse
    {
        $data = $request->validated();

        $dto = CustomerSignUpDto::fromValidatedRequest($data);

        $token = $this->customerService->generateAndSendOtp($dto->mobile_no, OtpPurpose::SIGNUP);

        return $this->generalSuccess([
            'message' => 'OTP sent to your mobile number.',
            'token' => $token
        ]);
    }
}
