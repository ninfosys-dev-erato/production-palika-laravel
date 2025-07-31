<?php

namespace Domains\CustomerGateway\Grievance\Services\v3;

use App\Facades\ImageServiceFacade;
use Domains\CustomerGateway\Grievance\DTO\GrievanceDto;
use Src\Customers\Models\Customer;
use Src\Grievance\Service\v3\GrievanceService;

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

}