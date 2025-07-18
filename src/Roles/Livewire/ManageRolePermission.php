<?php

namespace Src\Roles\Livewire;


use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Src\Roles\Service\RoleAdminService;


class ManageRolePermission extends Component
{
    public $roles;
    public $permissions;

    public function render()
    {
        return view("Roles::livewire.manage", [
            'roles' => $this->roles,
            'permissions' => $this->permissions,
        ]);
    }

    public function mount()
    {
        $this->roles = Role::with('permissions')->where('guard_name', 'web')->get();
        $this->permissions = Permission::where('guard_name', 'web')->get();
    }

    public function updatePermission($roleId, $permissionId)
    {
        $service = new RoleAdminService();
        $service->togglePermission($roleId, $permissionId);
        return true;
    }
}
