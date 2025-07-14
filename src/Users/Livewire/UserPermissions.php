<?php

namespace Src\Users\Livewire;

use App\Models\User;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Src\Permissions\Service\PermissionAdminService;

class UserPermissions extends Component
{
    public ?User $user;
    public $permissions;

    public function render()
    {
        return view('Users::livewire.permissions', [
            'permissions' => $this->permissions
        ]);
    }

    public function mount(User $user)
    {
        $this->user = $user;
        $this->permissions = Permission::all()
            ->groupBy(function ($permission) {
                return explode('_', $permission->name)[0];
            })->toArray();
    }

    public function togglePermission($roleId, $userId)
    {
        $service = new PermissionAdminService();
        $service->toggleUserPermission($userId, $roleId);
    }
}
