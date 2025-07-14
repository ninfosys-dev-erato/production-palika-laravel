<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\Organization;

class OrganizationsExport implements FromCollection
{
    public $organizations;

    public function __construct($organizations) {
        $this->organizations = $organizations;
    }

    public function collection()
    {
        return Organization::select([
'org_name_ne',
'org_name_en',
'org_email',
'org_contact',
'org_registration_no',
'org_registration_date',
'org_registration_document',
'org_pan_no',
'org_pan_registration_date',
'org_pan_document',
'logo',
'province_id',
'district_id',
'local_body_id',
'ward',
'tole',
'local_body_registration_date',
'local_body_registration_no',
'company_registration_document',
'is_active',
'is_organization',
'can_work',
'status',
'comment'
])
        ->whereIn('id', $this->organizations)->get();
    }
}


