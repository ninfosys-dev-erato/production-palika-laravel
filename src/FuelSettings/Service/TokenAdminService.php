<?php

namespace Src\FuelSettings\Service;

use Illuminate\Support\Facades\Auth;
use Src\FuelSettings\DTO\TokenAdminDto;
use Src\Tokens\Models\Token;

class TokenAdminService
{
public function store(TokenAdminDto $tokenAdminDto){
    return Token::create([
        'token_no' => $tokenAdminDto->token_no,
        'fiscal_year_id' => $tokenAdminDto->fiscal_year_id,
        'tokenable_type' => $tokenAdminDto->tokenable_type,
        'tokenable_id' => $tokenAdminDto->tokenable_id,
        'organization_id' => $tokenAdminDto->organization_id,
        'fuel_quantity' => $tokenAdminDto->fuel_quantity,
        'fuel_type' => $tokenAdminDto->fuel_type,
        'status' => $tokenAdminDto->status,
        'accepted_at' => $tokenAdminDto->accepted_at,
        'accepted_by' => $tokenAdminDto->accepted_by,
        'reviewed_at' => $tokenAdminDto->reviewed_at,
        'reviewed_by' => $tokenAdminDto->reviewed_by,
        'expires_at' => $tokenAdminDto->expires_at,
        'redeemed_at' => $tokenAdminDto->redeemed_at,
        'redeemed_by' => $tokenAdminDto->redeemed_by,
        'ward_no' => $tokenAdminDto->ward_no,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Token $token, TokenAdminDto $tokenAdminDto){
    return tap($token)->update([
        'token_no' => $tokenAdminDto->token_no,
        'fiscal_year_id' => $tokenAdminDto->fiscal_year_id,
        'tokenable_type' => $tokenAdminDto->tokenable_type,
        'tokenable_id' => $tokenAdminDto->tokenable_id,
        'organization_id' => $tokenAdminDto->organization_id,
        'fuel_quantity' => $tokenAdminDto->fuel_quantity,
        'fuel_type' => $tokenAdminDto->fuel_type,
        'status' => $tokenAdminDto->status,
        'accepted_at' => $tokenAdminDto->accepted_at,
        'accepted_by' => $tokenAdminDto->accepted_by,
        'reviewed_at' => $tokenAdminDto->reviewed_at,
        'reviewed_by' => $tokenAdminDto->reviewed_by,
        'expires_at' => $tokenAdminDto->expires_at,
        'redeemed_at' => $tokenAdminDto->redeemed_at,
        'redeemed_by' => $tokenAdminDto->redeemed_by,
        'ward_no' => $tokenAdminDto->ward_no,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Token $token){
    return tap($token)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Token::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


