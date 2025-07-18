<?php

namespace Domains\CustomerGateway\EmergencyContact\Services\v2;

use Illuminate\Database\Eloquent\Collection;
use Src\Downloads\Service\DownloadService;
use Src\EmergencyContacts\Models\EmergencyContact;
use Src\EmergencyContacts\Service\v2\EmergencyContactService;

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

    public function showContact(int $id)
    {
        return $this->emergencyContactService->showEmergencyContact($id);

    }
}