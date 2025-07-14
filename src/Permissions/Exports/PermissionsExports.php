<?php

namespace Src\Permissions\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Permissions\Models\Permission;

class PermissionsExport implements FromCollection
{
    public $permissions;

    public function __construct($permissions) {
        $this->permissions = $permissions;
    }

    public function collection()
    {
        return Permission::select([
'name',
'guard_name'
])
        ->whereIn('id', $this->permissions)->get();
    }
}


