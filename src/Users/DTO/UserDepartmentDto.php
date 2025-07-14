<?php

namespace Src\Users\DTO;

class UserDepartmentDto
{
    public function __construct(
        public int $department_id,
        public bool $is_department_head
    ) {}

    public static function fromInputs(array $selected_departments, array $department_heads): array
    {
        return array_map(function ($department_id) use ($department_heads) {
            return new self(
                department_id: $department_id,
                is_department_head: $department_heads[$department_id] ?? false
            );
        }, $selected_departments);
    }

}
