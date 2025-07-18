<?php

namespace App\Models\Passport;
use Laravel\Passport\RefreshToken as BaseRefreshToken;
class RefreshToken extends BaseRefreshToken
{
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($refreshToken) {
            $expiration = config("passport.token_expiry.{$refreshToken->client_id}")??null;
            if($expiration){
                $refreshToken->expires_at = now()->addMinutes($expiration['refresh_token']);
            }else{
                $refreshToken->expires_at = now()->addDays(5);
            }
        });
    }
}