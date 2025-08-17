<?php

namespace Src\Beruju\Service;

use Illuminate\Support\Facades\Auth;
use Src\Beruju\DTO\ResolutionCycleAdminDto;
use Src\Beruju\Models\ResolutionCycle;

class ResolutionCycleAdminService
{
    public function store(ResolutionCycleAdminDto $resolutionCycleAdminDto)
    {
        return ResolutionCycle::create([
            'beruju_id' => $resolutionCycleAdminDto->beruju_id,
            'incharge_id' => $resolutionCycleAdminDto->incharge_id,
            'assigned_by' => Auth::user()->id,
            'assigned_at' => now()->format('Y-m-d\TH:i'),
            'status' => $resolutionCycleAdminDto->status,
            'remarks' => $resolutionCycleAdminDto->remarks,
            'completed_at' => $resolutionCycleAdminDto->completed_at,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }

    public function update(ResolutionCycle $resolutionCycle, ResolutionCycleAdminDto $resolutionCycleAdminDto)
    {
        return tap($resolutionCycle)->update([
            'beruju_id' => $resolutionCycleAdminDto->beruju_id,
            'incharge_id' => $resolutionCycleAdminDto->incharge_id,
            'assigned_by' => Auth::user()->id,
            'assigned_at' => now()->format('Y-m-d\TH:i'),
            'status' => $resolutionCycleAdminDto->status,
            'remarks' => $resolutionCycleAdminDto->remarks,
            'completed_at' => $resolutionCycleAdminDto->completed_at,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }

    public function delete(ResolutionCycle $resolutionCycle)
    {
        return tap($resolutionCycle)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        ResolutionCycle::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
