<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class EmailOtp extends Model
{
    protected $fillable = ['user_id', 'otp', 'expires_at'];

    public function isExpired()
    {
        return Carbon::now()->greaterThan($this->expires_at);
    }
}
