<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ProcessIndicatorAdminDto;
use Src\Yojana\Models\ProcessIndicator;

class ProcessIndicatorAdminService
{
public function store(ProcessIndicatorAdminDto $processIndicatorAdminDto){
    return ProcessIndicator::create([
        'title' => $processIndicatorAdminDto->title,
        'unit_id' => $processIndicatorAdminDto->unit_id,
        'code' => $processIndicatorAdminDto->code,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ProcessIndicator $processIndicator, ProcessIndicatorAdminDto $processIndicatorAdminDto){
    return tap($processIndicator)->update([
        'title' => $processIndicatorAdminDto->title,
        'unit_id' => $processIndicatorAdminDto->unit_id,
        'code' => $processIndicatorAdminDto->code,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ProcessIndicator $processIndicator){
    return tap($processIndicator)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ProcessIndicator::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


