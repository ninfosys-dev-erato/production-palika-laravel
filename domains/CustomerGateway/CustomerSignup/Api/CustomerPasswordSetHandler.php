<?php

namespace Domains\CustomerGateway\CustomerSignup\Api;
use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\CustomerSignup\DTO\CustomerPasswordSetDto;
use Domains\CustomerGateway\CustomerSignup\Requests\CustomerPasswordSetRequest;
use Domains\CustomerGateway\CustomerSignup\Services\CustomerService;
use Illuminate\Http\JsonResponse;

class CustomerPasswordSetHandler extends Controller
{
    use ApiStandardResponse;

    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function setPassword(CustomerPasswordSetRequest $request): JsonResponse
    {
        $data = $request->validated();

        $dto = CustomerPasswordSetDto::fromValidatedRequest($data);

       $result =  $this->customerService->setPassword($dto);

        if ($result['success']) {
            return $this->generalSuccess(['message' => $result['message']]);
        }
        return $this->generalFailure(['message' => $result['message']]);

    }

}
