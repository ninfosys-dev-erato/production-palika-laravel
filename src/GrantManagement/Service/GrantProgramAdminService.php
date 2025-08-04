<?php

namespace Src\GrantManagement\Service;

use Illuminate\Support\Facades\Auth;
use Src\GrantManagement\DTO\GrantProgramAdminDto;
use Src\GrantManagement\Models\GrantProgram;

class GrantProgramAdminService
{
    public function store(GrantProgramAdminDto $grantProgramAdminDto)
    {
        return GrantProgram::create([
            'program_name' => $grantProgramAdminDto->program_name,
            'grant_amount' => $grantProgramAdminDto->grant_amount,
            'fiscal_year_id' => $grantProgramAdminDto->fiscal_year_id,
            'type_of_grant_id' => $grantProgramAdminDto->type_of_grant_id,
            'granting_organization_id' => $grantProgramAdminDto->granting_organization_id,
            'branch_id' => $grantProgramAdminDto->branch_id,
            'for_grant' => $grantProgramAdminDto->for_grant,
            'condition' => $grantProgramAdminDto->condition,
            'grant_provided_type' => $grantProgramAdminDto->grant_provided_type,
            'grant_provided_quantity' => $grantProgramAdminDto->grant_provided_quantity,
            'grant_provided' => $grantProgramAdminDto->grant_provided,
            'decision_type' => $grantProgramAdminDto->decision_type,
            'decision_date' => $grantProgramAdminDto->decision_date,

            'created_at' => now(),
            'created_by' => Auth::id(),
        ]);
    }
    public function update(GrantProgram $grantProgram, GrantProgramAdminDto $grantProgramAdminDto)
    {
        return tap($grantProgram)->update([
            'program_name' => $grantProgramAdminDto->program_name,
            'grant_amount' => $grantProgramAdminDto->grant_amount,
            'fiscal_year_id' => $grantProgramAdminDto->fiscal_year_id,
            'type_of_grant_id' => $grantProgramAdminDto->type_of_grant_id,
            'granting_organization_id' => $grantProgramAdminDto->granting_organization_id,
            'branch_id' => $grantProgramAdminDto->branch_id,
            'for_grant' => $grantProgramAdminDto->for_grant,
            'condition' => $grantProgramAdminDto->condition,
            'grant_provided_type' => $grantProgramAdminDto->grant_provided_type,
            'grant_provided_quantity' => $grantProgramAdminDto->grant_provided_quantity,
            'grant_provided' => $grantProgramAdminDto->grant_provided,
            'decision_type' => $grantProgramAdminDto->decision_type,
            'decision_date' => $grantProgramAdminDto->decision_date,
            'updated_at' => now(),
            'updated_by' => Auth::id(),
        ]);
    }
    public function delete(GrantProgram $grantProgram)
    {
        return tap($grantProgram)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        GrantProgram::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
