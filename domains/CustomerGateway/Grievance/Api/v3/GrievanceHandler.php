<?php

namespace Domains\CustomerGateway\Grievance\Api\v3;
use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\Grievance\DTO\GrievanceDto;
use Domains\CustomerGateway\Grievance\Requests\StoreGrievanceRequest;
use Domains\CustomerGateway\Grievance\Services\v3\DomainGrievanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GrievanceHandler extends Controller
{
    use ApiStandardResponse;

    protected $customer;

    protected $domainGrievanceService;

    public function __construct(DomainGrievanceService $domainGrievanceService)
    {
        $this->domainGrievanceService = $domainGrievanceService;
        $this->customer = Auth::guard('api-customer')->user();
    }

    public function create(StoreGrievanceRequest $request): JsonResponse
    {
        $data = $request->validated();
        $grievanceDto = GrievanceDto::fromValidatedRequest($data);
        
        $grievanceDto->files = $this->domainGrievanceService->imageBase64Save($grievanceDto);  
        $response = $this->domainGrievanceService->create($grievanceDto, $this->customer);  

        return $this->generalSuccess([
            'message' => $response['message']
        ]);      
    }

}