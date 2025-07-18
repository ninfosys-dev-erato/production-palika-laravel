<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\TargetCompletionAdminDto;
use Src\Yojana\Models\TargetCompletion;

class TargetCompletionAdminService
{
    public function store(TargetCompletionAdminDto $dto){
        return TargetCompletion::create([

            'plan_id' => $dto->plan_id,
            'target_entry_id' => $dto->target_entry_id,
            'completed_physical_goal' => $dto->completed_physical_goal,
            'completed_financial_goal' => $dto->completed_financial_goal,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(TargetCompletion $targetCompletion, TargetCompletionAdminDto $dto){
        return tap($targetCompletion)->update([

            'plan_id' => $dto->plan_id,
            'target_entry_id' => $dto->target_entry_id,
            'completed_physical_goal' => $dto->completed_physical_goal,
            'completed_financial_goal' => $dto->completed_financial_goal,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(TargetCompletion $targetCompletion){
        return tap($targetCompletion)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids){
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        TargetCompletion::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}


