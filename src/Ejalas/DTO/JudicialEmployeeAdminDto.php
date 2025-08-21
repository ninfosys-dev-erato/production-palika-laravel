<?php

namespace Src\Ejalas\DTO;

use Src\Ejalas\Models\JudicialEmployee;

class JudicialEmployeeAdminDto
{
    public function __construct(
        public string $name,
        public string $ward_id,
        public string $level_id,
        public string $designation_id,
        public string $join_date,
        public string $phone_no,
        public string $email
    ) {}

    public static function fromLiveWireModel(JudicialEmployee $judicialEmployee): JudicialEmployeeAdminDto
    {
        return new self(
            name: $judicialEmployee->name,
            ward_id: $judicialEmployee->ward_id,
            level_id: $judicialEmployee->level_id,
            designation_id: $judicialEmployee->designation_id,
            join_date: $judicialEmployee->join_date,
            phone_no: $judicialEmployee->phone_no,
            email: $judicialEmployee->email
        );
    }
}
