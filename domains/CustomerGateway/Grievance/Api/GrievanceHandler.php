<?php

namespace Domains\CustomerGateway\Grievance\Api;
use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\Grievance\DTO\GrievanceDto;
use Domains\CustomerGateway\Grievance\Requests\StoreGrievanceRequest;
use Domains\CustomerGateway\Grievance\Resources\GrievanceDetailResource;
use Domains\CustomerGateway\Grievance\Resources\GrievanceTypeResource;
use Domains\CustomerGateway\Grievance\Services\DomainGrievanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use Src\Grievance\Enums\GrievanceStatusEnum;
use Src\Grievance\Models\GrievanceDetail;
use Src\Grievance\Models\GrievanceType;

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

    public function myComplaints(): AnonymousResourceCollection
    { 
       $response =  $this->domainGrievanceService->myComplaints( $this->customer);  
        return GrievanceDetailResource::collection($response);
    }

    public function myComplaintsV2()
    { 
       $response =  $this->domainGrievanceService->myComplaintsV2($this->customer );  

        return GrievanceDetailResource::collection($response);
    }

    public function showComplaintDetail(int $id): AnonymousResourceCollection
    { 
        $response =  $this->domainGrievanceService->showComplaintDetail($id );  
        return GrievanceDetailResource::collection($response);
    }
    public function showComplaintDetailV2(int $id): GrievanceDetailResource
    { 
        $response =  $this->domainGrievanceService->showComplaintDetailV2($id ); 
        return new GrievanceDetailResource($response);
    }

    public function grievanceType(Request $request): JsonResponse
    {
        $response =  $this->domainGrievanceService->grievanceType( );
    
            return $this->generalSuccess([
                'message' => 'All the Grievance Type',
                'data' => $response
            ]);
    }

    public function countGrievance(Request $request)
    {
        $registeredCount = GrievanceDetail::all()->count();

        $processingCount = GrievanceDetail::whereIn('status', [GrievanceStatusEnum::INVESTIGATING, GrievanceStatusEnum::REPLIED])->count();

        $solvedCount = GrievanceDetail::where('status', GrievanceStatusEnum::CLOSED)->count();

        return $this->generalSuccess([
            'message' => 'All the Grievance Details Counts',
            'Registered' => $registeredCount,
            'Processing' => $processingCount,
            'Solved' => $solvedCount
        ]);
    }
}