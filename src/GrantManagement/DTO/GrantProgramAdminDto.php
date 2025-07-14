<?php

namespace Src\GrantManagement\DTO;

use Src\GrantManagement\Models\GrantProgram;

class GrantProgramAdminDto
{
    public function __construct(
        public string $program_name,
        public ?string $grant_amount,
        public string $fiscal_year_id,
        public string $type_of_grant_id,
        public string $granting_organization_id,
        public string $branch_id,
        public array $for_grant,
        public string $grant_provided_type,
        public string $condition,
        public ?string $grant_provided,
        public ?string $grant_provided_quantity
    ) {
    }

    public static function fromLiveWireModel(GrantProgram $grantProgram): GrantProgramAdminDto
    {

        return new self(
            program_name: $grantProgram->program_name,
            grant_amount: $grantProgram->grant_amount,
            fiscal_year_id: $grantProgram->fiscal_year_id,
            type_of_grant_id: $grantProgram->type_of_grant_id,
            granting_organization_id: $grantProgram->granting_organization_id,
            branch_id: $grantProgram->branch_id,
            for_grant: $grantProgram->for_grant,
            condition: $grantProgram->condition,
            grant_provided_type: $grantProgram->grant_provided_type,
            grant_provided_quantity: $grantProgram->grant_provided_quantity,
            grant_provided: $grantProgram->grant_provided,
        );
    }
}
