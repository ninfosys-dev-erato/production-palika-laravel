<?php

namespace Domains\CustomerGateway\CustomerKyc\Api;

use App\Http\Controllers\Controller;
use Domains\CustomerGateway\CustomerKyc\Requests\StoreCustomerKycRequest;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\CustomerKyc\DTO\CustomerKycDto;
use Domains\CustomerGateway\CustomerKyc\Requests\UpdateCustomerKycRequest;
use Domains\CustomerGateway\CustomerKyc\Services\DomainCustomerKycService;
use Illuminate\Http\JsonResponse;

class CustomerKycHandler extends Controller
{
    use ApiStandardResponse;
    protected $domainCustomerKycService;

    public function __construct(DomainCustomerKycService $domainCustomerKycService)
    {
        $this->domainCustomerKycService = $domainCustomerKycService;
    }

    public function store(StoreCustomerKycRequest $request): JsonResponse
    {
        $data = $request->validated();
        $dto = CustomerKycDto::buildFromValidatedRequest($data);
        $this->domainCustomerKycService->store($dto);

        return $this->generalSuccess([
            'message' => __('Your details have been stored successfully.'),
        ]);  
    }

    public function update(UpdateCustomerKycRequest $request): JsonResponse
    {
        $data = $request->validated();
        $dto = CustomerKycDto::buildFromValidatedRequest($data);
        $this->domainCustomerKycService->update($dto);

        return $this->generalSuccess(parameters: [
            'message' => __('Your details have been updated successfully.'),
        ]);  
    }

}