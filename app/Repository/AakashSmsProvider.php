<?php

namespace App\Repository;

use App\Contracts\SmsServiceInterface;

class AakashSmsProvider implements SmsServiceInterface
{
    public HttpProvider $httpProvider;

    public function __construct()
    {
        $this->httpProvider = new HttpProvider();
    }

    public function sendSms($number, $message): bool
    {
        $url = config('aakash.sms_url');
        $args = array(
            'auth_token' => config('aakash.sms_key'),
            'to' => $number,
            'text' => $message,
        );
        $response = $this->httpProvider->post($url, $args);

        return isset($response['error']) && !$response['error'];
    }

    public function creditsAvailable(): float
    {
        $url = config('aakash.credit_check_url');
        $args = array(
            'auth_token' => config('aakash.sms_key')
        );
        $response = $this->httpProvider->post($url, $args);
        return isset($response['available_credit']) ? floatval($response['available_credit']) : 0.0;
    }
}
