<?php

namespace Src\EmergencyContacts\Service;

use App\Services\ImageService;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Src\Downloads\Models\Download;
use Src\EmergencyContacts\Models\EmergencyContact;
use Src\Employees\Models\Employee;

class EmergencyContactService
{
    public function showEmergencyContactList(): Collection
    {
        $contact = QueryBuilder::for(EmergencyContact::class)
            ->allowedFilters(['service_name', 'contact_numbers', 'contact_person', 'address'])
            ->allowedSorts(['service_name', 'contact_numbers', 'created_at'])
            ->get();

        return $contact;
    }
    
}