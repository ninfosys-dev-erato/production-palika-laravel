<?php

namespace Domains\CustomerGateway\CustomerSignup\Api;
use App\Enums\OtpPurpose;
use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\CustomerSignup\DTO\CustomerForgotPasswordDto;
use Domains\CustomerGateway\CustomerSignup\Requests\CustomerForgotPasswordRequest;
use Domains\CustomerGateway\CustomerSignup\Services\CustomerService;
use Illuminate\Http\JsonResponse;

class CustomerForgotPasswordHandler extends Controller
{
    use ApiStandardResponse;
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function forgotPassword(CustomerForgotPasswordRequest $request): JsonResponse
    {
        $data = $request->validated();

        $dto = CustomerForgotPasswordDto::fromValidatedRequest($data);

        $token = $this->customerService->generateAndSendOtp($dto->mobile_no, OtpPurpose::FORGOTPASSWORD);

        return $this->generalSuccess([
            'message' => 'A OTP has been sent to your mobile number. Please check your SMS.',
            'token' => $token
        ]);

    }

}
