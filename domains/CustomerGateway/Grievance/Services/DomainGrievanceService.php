<?php

namespace Domains\CustomerGateway\Grievance\Services;
use App\Facades\ImageServiceFacade;
use Domains\CustomerGateway\Grievance\DTO\GrievanceDto;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Src\Customers\Models\Customer;
use Src\Grievance\Models\GrievanceDetail;
use Src\Grievance\Service\GrievanceService;

class DomainGrievanceService
{
    protected GrievanceService $grievanceService;
    protected $customer;

    public function __construct(GrievanceService $grievanceService)
    {
        $this->grievanceService = $grievanceService;
    }

    public function create(GrievanceDto $grievanceDto, Customer $customer): array|string|null
    {
       return $this->grievanceService->create($grievanceDto, $customer);
    }

    public function imageBase64Save(GrievanceDto $grievanceDto): array|null 
    {
        
        $fileNames = [];
        if (!empty($grievanceDto->files)) {
            foreach ($grievanceDto->files as $file) {
                if($grievanceDto->is_public === true)
                {
                    $image = ImageServiceFacade::base64Save($file, config('src.Grievance.grievance.path'), getStorageDisk('public'));
                }
                else{
                    $image = ImageServiceFacade::base64Save($file, config('src.Grievance.grievance.path'), getStorageDisk('private'));
                }
                $fileNames[] = $image;
            }
        }
        return $fileNames;
    }

    public function myComplaints(Customer $customer): Collection
    {
        return $this->grievanceService->complaintsByUser($customer->id);
    }
    public function myComplaintsV2(Customer $customer): LengthAwarePaginator
    {
        return $this->grievanceService->complaintsByUserV2( $customer->id);
    }
    public function showComplaintDetail(int $id): Collection
    {
        return $this->grievanceService->showComplaintDetail($id);
    }
    public function showComplaintDetailV2(int $id): GrievanceDetail|null
    {
        return $this->grievanceService->showComplaintDetailV2($id);
    }
    public function allComplain(): Collection
    {
        return $this->grievanceService->showAllComplaints();
    }
    public function allComplaintsV2(): LengthAwarePaginator
    {
        return $this->grievanceService->showAllComplaintsV2();
    }
    public function grievanceType()
    {
        return $this->grievanceService->grievanceType();
    }
}