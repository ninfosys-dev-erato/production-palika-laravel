<?php

namespace App\Repository;

use App\Contracts\SmsServiceInterface;

class DoitSmsProvider implements SmsServiceInterface
{
    public HttpProvider $httpProvider;
    public function __construct()
    {
        $this->httpProvider = new HttpProvider();
    }
    public function sendSms($number, $message): bool
    {
        $url = config('diot.sms_url');
        $args = array(
            'auth_token' => config('diot.sms_key'),
            'mobile' => $number,
            'message' => $message,
        );
        $response = $this->httpProvider->post($url, $args);

        return isset($response['error']) && !$response['error'];
    }

    public function creditsAvailable(): float
    {
        $url = config('diot.credit_check_url');
        $args = array(
            'auth_token' => config('diot.sms_key')
        );
        $response = $this->httpProvider->post($url, $args);
        return isset($response['balance']) ? floatval($response['balance']) : 0.0;
    }
}
