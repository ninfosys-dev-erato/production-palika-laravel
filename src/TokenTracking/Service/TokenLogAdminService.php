<?php

namespace Src\TokenTracking\Service;

use Illuminate\Support\Facades\Auth;
use Src\TokenTracking\DTO\TokenLogAdminDto;
use Src\TokenTracking\Models\TokenLog;

class TokenLogAdminService
{
public function store(TokenLogAdminDto $tokenLogAdminDto){
    return TokenLog::create([
        'token_id' => $tokenLogAdminDto->token_id,
        'old_status' => $tokenLogAdminDto->old_status,
        'new_status' => $tokenLogAdminDto->new_status,
        'status' => $tokenLogAdminDto->status,
        'stage_status' => $tokenLogAdminDto->stage_status,
        'old_branch' => $tokenLogAdminDto->old_branch,
        'new_branch' => $tokenLogAdminDto->new_branch,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(TokenLog $tokenLog, TokenLogAdminDto $tokenLogAdminDto){
    return tap($tokenLog)->update([
        'token_id' => $tokenLogAdminDto->token_id,
        'old_status' => $tokenLogAdminDto->old_status,
        'new_status' => $tokenLogAdminDto->new_status,
        'status' => $tokenLogAdminDto->status,
        'stage_status' => $tokenLogAdminDto->stage_status,
        'old_branch' => $tokenLogAdminDto->old_branch,
        'new_branch' => $tokenLogAdminDto->new_branch,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(TokenLog $tokenLog){
    return tap($tokenLog)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    TokenLog::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


