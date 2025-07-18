<?php

namespace Src\TokenTracking\Service;

use Illuminate\Support\Facades\Auth;
use Src\TokenTracking\DTO\RegisterTokenLogAdminDto;
use Src\TokenTracking\Models\RegisterTokenLog;

class RegisterTokenLogAdminService
{
public function store(RegisterTokenLogAdminDto $registerTokenLogAdminDto){
    return RegisterTokenLog::create([
        'token_id' => $registerTokenLogAdminDto->token_id,
        'old_branch' => $registerTokenLogAdminDto->old_branch,
        'current_branch' => $registerTokenLogAdminDto->current_branch,
        'old_stage' => $registerTokenLogAdminDto->old_stage,
        'current_stage' => $registerTokenLogAdminDto->current_stage,
        'old_status' => $registerTokenLogAdminDto->old_status,
        'current_status' => $registerTokenLogAdminDto->current_status,
        'old_values' => $registerTokenLogAdminDto->old_values,
        'current_values' => $registerTokenLogAdminDto->current_values,
        'description' => $registerTokenLogAdminDto->description,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(RegisterTokenLog $registerTokenLog, RegisterTokenLogAdminDto $registerTokenLogAdminDto){
    return tap($registerTokenLog)->update([
        'token_id' => $registerTokenLogAdminDto->token_id,
        'old_branch' => $registerTokenLogAdminDto->old_branch,
        'current_branch' => $registerTokenLogAdminDto->current_branch,
        'old_stage' => $registerTokenLogAdminDto->old_stage,
        'current_stage' => $registerTokenLogAdminDto->current_stage,
        'old_status' => $registerTokenLogAdminDto->old_status,
        'current_status' => $registerTokenLogAdminDto->current_status,
        'old_values' => $registerTokenLogAdminDto->old_values,
        'current_values' => $registerTokenLogAdminDto->current_values,
        'description' => $registerTokenLogAdminDto->description,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(RegisterTokenLog $registerTokenLog){
    return tap($registerTokenLog)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    RegisterTokenLog::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


