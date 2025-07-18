<?php

namespace App\Models\Passport;
use Laravel\Passport\Token as PassportToken;

class Token extends PassportToken
{
    /**
     * The "booting" method of the model.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($refreshToken) {
            $expiration = config("passport.token_expiry.{$refreshToken->client_id}")??null;
            if($expiration){
                $refreshToken->expires_at = now()->addMinutes($expiration['access_token']);
            }else{
                $refreshToken->expires_at = now()->addDays(2);
            }
            self::disablePreviousTokens($refreshToken->client_id,$refreshToken->user_id);
        });
    }

    protected static function disablePreviousTokens(string $client_id , string $user_id)
    {
        return Token::where('client_id', $client_id)->where('user_id', $user_id)->lockForUpdate()->update(['revoked' => true]);
    }
}