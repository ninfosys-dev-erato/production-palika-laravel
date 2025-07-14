<?php

namespace Src\Grievance\Service;

use Illuminate\Support\Facades\Auth;
use Src\Employees\Models\Branch;
use Src\Grievance\DTO\GrievanceTypeAdminDto;
use Src\Grievance\Models\GrievanceType;
use Spatie\Permission\Models\Role;

class GrievanceTypeAdminService
{
    public function store(GrievanceTypeAdminDto $grievanceTypeAdminDto, $selectedRoles, $selectedDepartments)
    {
        $grievanceType =  GrievanceType::create([
            'title' => $grievanceTypeAdminDto->title,
            'is_ward' => $grievanceTypeAdminDto->is_ward,
        ]);
        $grievanceType->roles()->sync($selectedRoles);
        $grievanceType->departments()->sync($selectedDepartments);
    }

    public function update(GrievanceType $grievanceType, GrievanceTypeAdminDto $grievanceTypeAdminDto, $selectedRoles, $selectedDepartments)
    {
        $grievanceType = tap($grievanceType)->update([
            'title' => $grievanceTypeAdminDto->title,
            'is_ward' => $grievanceTypeAdminDto->is_ward,
        ]);
        $grievanceType->departments()->sync($selectedDepartments);
        $grievanceType->roles()->sync($selectedRoles);
    }

    public function delete(GrievanceType $grievanceType)
    {

        return tap($grievanceType)->update([
            'deleted_at' => now(),
        ]);
    }

    public function collectionDelete(array $ids): void
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        GrievanceType::whereIn('id', $numericIds)->update([
            'deleted_at' => now(),
        ]);
    }

    public function toggleGrievanceNotifee($typeId, $roleId)
    {
        $type = GrievanceType::find($typeId);
        $role = Role::findById($roleId);
        if ($type->hasRole($role->name)) {
            return $type->removeRole($role->name);
        } else {
            return $type->assignRole($role->name);
        }
    }
}
