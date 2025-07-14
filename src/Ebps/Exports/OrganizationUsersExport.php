<?php

namespace Src\Ebps\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Ebps\Models\OrganizationUser;

class OrganizationUsersExport implements FromCollection
{
    public $organization_users;

    public function __construct($organization_users) {
        $this->organization_users = $organization_users;
    }

    public function collection()
    {
        return OrganizationUser::select([
'name',
'email',
'photo',
'phone',
'password',
'is_active',
'is_organization',
'organizations_id',
'can_work',
'status',
'comment'
])
        ->whereIn('id', $this->organization_users)->get();
    }
}


