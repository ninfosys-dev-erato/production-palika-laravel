<?php

namespace Src\GrantManagement\DTO;

use Src\GrantManagement\Models\Grant;

class GrantAdminDto
{
   public function __construct(
        public string $fiscal_year_id,
        public string $grant_type_id,
        public string $grant_office_id,
        public string $grant_program_name,
        public string $branch_id,
        public string $grant_amount,
        public string $grant_for,
        public string $main_activity,
        public string $remarks,
        public string $user_id
    ){}

public static function fromLiveWireModel(Grant $grant):GrantAdminDto{
    return new self(
        fiscal_year_id: $grant->fiscal_year_id,
        grant_type_id: $grant->grant_type_id,
        grant_office_id: $grant->grant_office_id,
        grant_program_name: $grant->grant_program_name,
        branch_id: $grant->branch_id,
        grant_amount: $grant->grant_amount,
        grant_for: $grant->grant_for,
        main_activity: $grant->main_activity,
        remarks: $grant->remarks,
        user_id: $grant->user_id
    );
}
}
