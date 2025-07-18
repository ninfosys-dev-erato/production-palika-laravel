<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\LogBookAdminDto;
use Src\Yojana\Models\LogBook;

class LogBookAdminService
{
public function store(LogBookAdminDto $logBookAdminDto){
    return LogBook::create([
        'employee_id' => $logBookAdminDto->employee_id,
        'date' => $logBookAdminDto->date,
        'visit_time' => $logBookAdminDto->visit_time,
        'return_time' => $logBookAdminDto->return_time,
        'visit_type' => $logBookAdminDto->visit_type,
        'visit_purpose' => $logBookAdminDto->visit_purpose,
        'description' => $logBookAdminDto->description,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(LogBook $logBook, LogBookAdminDto $logBookAdminDto){
    return tap($logBook)->update([
        'employee_id' => $logBookAdminDto->employee_id,
        'date' => $logBookAdminDto->date,
        'visit_time' => $logBookAdminDto->visit_time,
        'return_time' => $logBookAdminDto->return_time,
        'visit_type' => $logBookAdminDto->visit_type,
        'visit_purpose' => $logBookAdminDto->visit_purpose,
        'description' => $logBookAdminDto->description,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(LogBook $logBook){
    return tap($logBook)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    LogBook::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


