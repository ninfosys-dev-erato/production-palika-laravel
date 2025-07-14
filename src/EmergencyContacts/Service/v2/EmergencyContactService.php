<?php

namespace Src\EmergencyContacts\Service\v2;

use App\Services\ImageService;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Src\Downloads\Models\Download;
use Src\EmergencyContacts\Enum\ContactPages;
use Src\EmergencyContacts\Models\EmergencyContact;
use Src\Employees\Models\Employee;

class EmergencyContactService
{
    public function showEmergencyContactList()
    {
        $contact = QueryBuilder::for(EmergencyContact::class)
            ->allowedFilters([
                'service_name',
                'contact_numbers',
                'contact_person',
                'address',
                'group' 
            ])
            ->allowedSorts(['service_name', 'contact_numbers', 'created_at'])
            ->whereNull('deleted_at')
            ->whereNull('parent_id')
            ->with('sedfrvices')
            ->get();

        return $contact;
    }

    public function showEmergencyContact(int $id)
    {
        return EmergencyContact::with('services')
            ->where('id', $id)
            ->first();

    }

}
