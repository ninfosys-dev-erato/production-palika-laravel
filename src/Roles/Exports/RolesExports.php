<?php

namespace Src\Roles\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Roles\Models\Role;

class RolesExport implements FromCollection
{
    public $roles;

    public function __construct($roles) {
        $this->roles = $roles;
    }

    public function collection()
    {
        return Role::select([
'name',
'guard_name'
])
        ->whereIn('id', $this->roles)->get();
    }
}


