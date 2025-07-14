<?php

namespace Src\FuelSettings\DTO;

use Src\Tokens\Models\Token;

class TokenAdminDto
{
   public function __construct(
        public string $token_no,
        public string $fiscal_year_id,
        public string $tokenable_type,
        public string $tokenable_id,
        public string $organization_id,
        public string $fuel_quantity,
        public string $fuel_type,
        public string $status,
        public string $accepted_at,
        public string $accepted_by,
        public string $reviewed_at,
        public string $reviewed_by,
        public string $expires_at,
        public string $redeemed_at,
        public string $redeemed_by,
        public string $ward_no
    ){}

public static function fromLiveWireModel(Token $token):TokenAdminDto{
    return new self(
        token_no: $token->token_no,
        fiscal_year_id: $token->fiscal_year_id,
        tokenable_type: $token->tokenable_type,
        tokenable_id: $token->tokenable_id,
        organization_id: $token->organization_id,
        fuel_quantity: $token->fuel_quantity,
        fuel_type: $token->fuel_type,
        status: $token->status,
        accepted_at: $token->accepted_at,
        accepted_by: $token->accepted_by,
        reviewed_at: $token->reviewed_at,
        reviewed_by: $token->reviewed_by,
        expires_at: $token->expires_at,
        redeemed_at: $token->redeemed_at,
        redeemed_by: $token->redeemed_by,
        ward_no: $token->ward_no
    );
}
}
