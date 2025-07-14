<?php

namespace Src\Meetings\Service;

use Illuminate\Support\Facades\Auth;
use Src\Meetings\DTO\DecisionAdminDto;
use Src\Meetings\Models\Decision;

class DecisionAdminService
{
public function store(DecisionAdminDto $decisionAdminDto){
    return Decision::create([
        'meeting_id' => $decisionAdminDto->meeting_id,
        'date' => $decisionAdminDto->date,
        'chairman' => $decisionAdminDto->chairman,
        'en_date' => $decisionAdminDto->en_date,
        'description' => $decisionAdminDto->description,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Decision $decision, DecisionAdminDto $decisionAdminDto){
    return tap($decision)->update([
        'meeting_id' => $decisionAdminDto->meeting_id,
        'date' => $decisionAdminDto->date,
        'chairman' => $decisionAdminDto->chairman,
        'en_date' => $decisionAdminDto->en_date,
        'description' => $decisionAdminDto->description,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Decision $decision){
    return tap($decision)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Decision::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}
