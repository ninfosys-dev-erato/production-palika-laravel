<?php

namespace Src\EmergencyContacts\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\EmergencyContacts\Models\EmergencyContact;

class EmergencyContactsExport implements FromCollection
{
    public $emergency_contacts;

    public function __construct($emergency_contacts) {
        $this->emergency_contacts = $emergency_contacts;
    }

    public function collection()
    {
        return EmergencyContact::select([
'service_name',
'icon',
'contact_person',
'address',
'contact_numbers'
])
        ->whereIn('id', $this->emergency_contacts)->get();
    }
}


