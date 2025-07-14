<?php

namespace Domains\CustomerGateway\Grievance\Api;
use App\Http\Controllers\Controller;
use Domains\CustomerGateway\Grievance\Resources\GrievanceDetailResource;
use Domains\CustomerGateway\Grievance\Services\DomainGrievanceService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ShowAllComplaintsHandler extends Controller
{
    protected DomainGrievanceService $domainGrievanceService;

    public function __construct(DomainGrievanceService $domainGrievanceService)
    {
        $this->domainGrievanceService = $domainGrievanceService;
    }
    public function allComplaints(): AnonymousResourceCollection
    { 
       $response =  $this->domainGrievanceService->allComplain();  
        return GrievanceDetailResource::collection($response);
    }
    public function allComplaintsV2(): AnonymousResourceCollection
    { 
       $response =  $this->domainGrievanceService->allComplaintsV2();  
        return GrievanceDetailResource::collection($response);
    }
}