<?php

namespace Domains\CustomerGateway\CustomerSignup\Api;
use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\CustomerSignup\DTO\CustomerLanguagePreferenceDto;
use Domains\CustomerGateway\CustomerSignup\Requests\CustomerLanguagePreferenceRequest;
use Domains\CustomerGateway\CustomerSignup\Services\CustomerService;
use Illuminate\Http\JsonResponse;

class CustomerLanguagePreferenceHandler extends Controller
{
    use ApiStandardResponse;

    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function setLanguage(CustomerLanguagePreferenceRequest $request): JsonResponse
    {
        $data = $request->validated();
        $dto = CustomerLanguagePreferenceDto::fromValidatedRequest($data);

       $result =  $this->customerService->setLangauge($dto);

        if ($result['success']) {
            return $this->generalSuccess(['message' => $result['message']]);
        }
        return $this->generalFailure(['message' => $result['message']]);
    }
}
