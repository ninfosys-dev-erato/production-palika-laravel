<?php

namespace Src\TokenTracking\Service;

use Illuminate\Support\Facades\Auth;
use Src\TokenTracking\DTO\TokenHolderAdminDto;
use Src\TokenTracking\Models\TokenHolder;

class TokenHolderAdminService
{
public function store(TokenHolderAdminDto $tokenHolderAdminDto){
    return TokenHolder::create([
        'name' => $tokenHolderAdminDto->name,
        'email' => $tokenHolderAdminDto->email,
        'mobile_no' => $tokenHolderAdminDto->mobile_no,
        'address' => $tokenHolderAdminDto->address,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(TokenHolder $tokenHolder, TokenHolderAdminDto $tokenHolderAdminDto){
    return tap($tokenHolder)->update([
        'name' => $tokenHolderAdminDto->name,
        'email' => $tokenHolderAdminDto->email,
        'mobile_no' => $tokenHolderAdminDto->mobile_no,
        'address' => $tokenHolderAdminDto->address,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(TokenHolder $tokenHolder){
    return tap($tokenHolder)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    TokenHolder::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


