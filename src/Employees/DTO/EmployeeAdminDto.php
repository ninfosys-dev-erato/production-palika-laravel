<?php

namespace Src\Employees\DTO;

use Src\Employees\Enums\GenderEnum;
use Src\Employees\Enums\TypeEnum;
use Src\Employees\Models\Designation;
use Src\Employees\Models\Employee;

class EmployeeAdminDto
{
    public function __construct(
        public string          $name,
        public string          $address,
        public GenderEnum      $gender,
        public ?string         $pan_no,
        public ?bool         $is_department_head,
        public ?string         $photo,
        public ?string         $email,
        public ?string         $phone,
        public ?TypeEnum        $type,
        public ?string         $remarks,
        public ?int             $branch_id,
        public int|string|null $ward_no,
        public int|null           $designation_id,
        public int|null $user_id,
        public int|null $position,
    ) {}

    public static function fromLiveWireModel(Employee $employee): EmployeeAdminDto
    {
        return new self(
            name: $employee->name,
            address: $employee->address,
            gender: $employee->gender,
            pan_no: $employee->pan_no,
            is_department_head: $employee->is_department_head,
            photo: $employee->photo,
            email: $employee->email,
            phone: $employee->phone,
            type: $employee->type,
            remarks: $employee->remarks,
            branch_id: $employee->branch_id == 0 ? null : $employee->branch_id,
            ward_no: $employee->ward_no ?? 0,
            designation_id: $employee->designation_id == 0 ? null : $employee->designation_id ,
            user_id: $employee->user_id ?? null,
            position: $employee->position
        );
    }
}
