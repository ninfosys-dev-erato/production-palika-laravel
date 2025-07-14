<?php

namespace App\Repository;

use App\Contracts\SmsServiceInterface;

class DummySmsProvider implements SmsServiceInterface
{
    public HttpProvider $httpProvider;


    public function sendSms($number, $message): bool
    {
        return true;
    }

    public function creditsAvailable(): float
    {
        return 100;
    }
}
