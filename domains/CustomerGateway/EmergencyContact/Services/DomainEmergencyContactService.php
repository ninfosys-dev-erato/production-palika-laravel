<?php

namespace Domains\CustomerGateway\EmergencyContact\Services;

use Illuminate\Database\Eloquent\Collection;
use Src\Downloads\Service\DownloadService;
use Src\EmergencyContacts\Service\EmergencyContactService;

class DomainEmergencyContactService
{
    protected $emergencyContactService;

    public function __construct(EmergencyContactService $emergencyContactService)
    {
        $this->emergencyContactService = $emergencyContactService;
    }

    public function show(): Collection
    {
        return $this->emergencyContactService->showEmergencyContactList();
    }

}