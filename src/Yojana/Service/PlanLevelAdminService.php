<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\PlanLevelAdminDto;
use Src\Yojana\Models\PlanLevel;

class PlanLevelAdminService
{
    public function store(PlanLevelAdminDto $planLevelAdminDto)
    {
        return PlanLevel::create([
            'level_name' => $planLevelAdminDto->level_name,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(PlanLevel $planLevel, PlanLevelAdminDto $planLevelAdminDto)
    {
        return tap($planLevel)->update([
            'level_name' => $planLevelAdminDto->level_name,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(PlanLevel $planLevel)
    {
        return tap($planLevel)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        PlanLevel::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
