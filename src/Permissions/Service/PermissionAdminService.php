<?php

namespace Src\Permissions\Service;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Src\Permissions\DTO\PermissionAdminDto;
use Src\Permissions\Models\Permission;

class PermissionAdminService
{
    public function store(PermissionAdminDto $permissionAdminDto)
    {
        return Permission::create([
            'name' => $permissionAdminDto->name,
            'guard_name' => $permissionAdminDto->guard_name,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(Permission $permission, PermissionAdminDto $permissionAdminDto)
    {
        return tap($permission)->update([
            'name' => $permissionAdminDto->name,
            'guard_name' => $permissionAdminDto->guard_name,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(Permission $permission)
    {
        return tap($permission)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function toggleUserPermission($userId, $roleId)
    {
        $user = User::find($userId);
        $permission = \Spatie\Permission\Models\Permission::findById($roleId);
        if ($user->hasPermissionTo($permission->name)) {
            return $user->revokePermissionTo($permission->name);
        } else {
            return $user->givePermissionTo($permission->name);
        }
    }
}
