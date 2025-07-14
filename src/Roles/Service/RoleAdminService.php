<?php

namespace Src\Roles\Service;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Src\Roles\DTO\RoleAdminDto;
use Src\Roles\Models\Role;

class RoleAdminService
{
    public function store(RoleAdminDto $roleAdminDto){
        return Role::create([
            'name' => $roleAdminDto->name,
            'guard_name' => $roleAdminDto->guard_name,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(Role $role, RoleAdminDto $roleAdminDto){
        return tap($role)->update([
            'name' => $roleAdminDto->name,
            'guard_name' => $roleAdminDto->guard_name,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(Role $role){
        return tap($role)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function togglePermission($roleId,$permissionId){
        $role = \Spatie\Permission\Models\Role::findById($roleId);
        $permission = Permission::find($permissionId);
        if($role->hasPermissionTo($permission->name)){
            $role->revokePermissionTo($permission->name);
        }else{
            $role->givePermissionTo($permission->name);
        }
    }

    public function toggleUserRole($userId,$roleId){
        $user = User::find($userId);
        $role = Role::find($roleId);
        if($user->hasRole($role->name)){
           return $user->removeRole($role->name);
        }else{
           return $user->assignRole($role->name);
        }
    }
}


