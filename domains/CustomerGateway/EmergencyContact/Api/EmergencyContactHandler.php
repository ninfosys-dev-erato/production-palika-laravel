<?php

namespace Domains\CustomerGateway\EmergencyContact\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiStandardResponse;
use Domains\CustomerGateway\Downloads\Resources\DownloadResource;
use Domains\CustomerGateway\EmergencyContact\Resources\EmergencyContactResource;
use Domains\CustomerGateway\EmergencyContact\Services\DomainEmergencyContactService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EmergencyContactHandler extends Controller
{
    use ApiStandardResponse;
    protected $domainEmergencyContactService;

    public function __construct(DomainEmergencyContactService $domainEmergencyContactService)
    {
        $this->domainEmergencyContactService = $domainEmergencyContactService;
    }
    public function show(Request $request): AnonymousResourceCollection
    {
        $contacts =$this->domainEmergencyContactService->show(); 
        return EmergencyContactResource::collection($contacts);
    }
}