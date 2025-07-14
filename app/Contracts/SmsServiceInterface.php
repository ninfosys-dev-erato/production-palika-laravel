<?php

namespace App\Contracts;

interface SmsServiceInterface
{
    public function sendSms($number, $message):bool;

    public function creditsAvailable():float;

}
