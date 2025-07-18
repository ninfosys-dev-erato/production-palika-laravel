<?php

namespace Src\GrantManagement\Service;

use Illuminate\Support\Facades\Auth;
use Src\GrantManagement\DTO\GrantReleaseAdminDto;
use Src\GrantManagement\Models\GrantRelease;

class GrantReleaseAdminService
{
    public function store(GrantReleaseAdminDto $dto)
    {
        return GrantRelease::create([
            'grantee_id' => $dto->grantee_id,
            'grantee_name' => $dto->grantee_name,
            'grantee_type' => $dto->grantee_type,
            'investment' => $dto->investment,
            'is_new_or_ongoing' => $dto->is_new_or_ongoing,
            'last_year_investment' => $dto->last_year_investment,
            'plot_no' => $dto->plot_no,
            'location' => $dto->location,
            'contact_person' => $dto->contact_person,
            'contact_no' => $dto->contact_no,
            'condition' => $dto->condition,
            'grant_program' => $dto->grant_program,
            'created_at' => now(),
            'created_by' => Auth::id(),
        ]);
    }



    public function update(GrantRelease $model, GrantReleaseAdminDto $dto)
    {
        // Only update fields that exist in the database
        return tap($model)->update([
            'grantee_id' => $dto->grantee_id,
            'grantee_name' => $dto->grantee_name,
            'grantee_type' => $dto->grantee_type,
            'investment' => $dto->investment, // Map to DB column
            'is_new_or_ongoing' => $dto->is_new_or_ongoing,      // Map to DB column
            'last_year_investment' => $dto->last_year_investment,
            'plot_no' => $dto->plot_no,
            'location' => $dto->location,       // Map to DB column
            'contact_person' => $dto->contact_person,
            'contact_no' => $dto->contact_no,
            'condition' => $dto->condition,
            'grant_program' => $dto->grant_program,
            'updated_at' => now(),
            'updated_by' => Auth::id(),
        ]);
    }


    public function delete(GrantRelease $model)
    {
        return tap($model)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::id(),
        ]);
    }

    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        GrantRelease::whereIn('id', $numericIds)->update([
            'deleted_at' => now(),
            'deleted_by' => Auth::id(),
        ]);
    }
}
