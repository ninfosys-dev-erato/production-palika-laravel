<?php

namespace Src\Employees\Service;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Src\Employees\DTO\EmployeeAdminDto;
use Src\Employees\Models\Employee;
use Src\Users\DTO\UserAdminDto;
use Src\Users\DTO\UserRoleDto;
use Src\Users\Service\UserAdminService;

class EmployeeAdminService
{
    public function store(EmployeeAdminDto $employeeAdminDto)
    {
        return  Employee::create([
            'name' => $employeeAdminDto->name,
            'address' => $employeeAdminDto->address,
            'gender' => $employeeAdminDto->gender,
            'position' => $employeeAdminDto->position,
            'pan_no' => $employeeAdminDto->pan_no,
            'is_department_head' => $employeeAdminDto->is_department_head,
            'photo' => $employeeAdminDto->photo,
            'email' => $employeeAdminDto->email,
            'phone' => $employeeAdminDto->phone,
            'type' => $employeeAdminDto->type,
            'remarks' => $employeeAdminDto->remarks,
            'branch_id' => $employeeAdminDto->branch_id,
            'ward_no' => $employeeAdminDto->ward_no,
            'designation_id' => $employeeAdminDto->designation_id,
            'user_id' => $employeeAdminDto->user_id,
            'created_by' => Auth::id(),
        ]);
    }

    public function update(Employee $employee, EmployeeAdminDto $employeeAdminDto)
    {
        return tap($employee)->update([
            'name' => $employeeAdminDto->name,
            'address' => $employeeAdminDto->address,
            'gender' => $employeeAdminDto->gender,
            'pan_no' => $employeeAdminDto->pan_no,
            'is_department_head' => $employeeAdminDto->is_department_head,
            'photo' => $employeeAdminDto->photo,
            'email' => $employeeAdminDto->email,
            'phone' => $employeeAdminDto->phone,
            'type' => $employeeAdminDto->type,
            'remarks' => $employeeAdminDto->remarks,
            'branch_id' => $employeeAdminDto->branch_id,
            'ward_no' => $employeeAdminDto->ward_no,
            'designation_id' => $employeeAdminDto->designation_id,
            'user_id' => $employeeAdminDto->user_id,
            'updated_by' => Auth::id(),
            'position' => $employeeAdminDto->position,
        ]);
    }

    public function delete(Employee $employee)
    {
        return tap($employee)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids): void
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Employee::whereIn('id', $numericIds)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function createUser(UserAdminDto $userDto, array $roleDtos): void
    {
        $service = new UserAdminService();

        $user = $service->store($userDto);
        $service->saveUserRoles($user, $roleDtos);
    }
}
