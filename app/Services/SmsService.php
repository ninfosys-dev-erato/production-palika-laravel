<?php

namespace App\Services;

use App\Contracts\SmsServiceInterface;
use App\Repository\AakashSmsProvider;
use App\Repository\DummySmsProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use App\Repository\DoitSmsProvider;

class SmsService
{
    public function sendSms($recipient, $message): bool
    {
        $selectedProvider = $this->selectProvider();
        $result =  $selectedProvider->sendSms($recipient, $message);
        if($result){
            Cache::decrement('sms_credit', 1);
        }
        return $result;
    }
    public function creditsAvailable():float
    {
        if(is_null(cache('sms_credit')) || cache('sms_credit') == 0){
            $selectedProvider = $this->selectProvider();
            $credits =  $selectedProvider->creditsAvailable();
            Cache::forget('sms_credit');
            Cache::add('sms_credit', $credits);
        }
        return cache('sms_credit');
    }
    private function selectProvider(): SmsServiceInterface
    {
        if(App::environment('production')){
            $providers = [new AakashSmsProvider()];
        }else{
            $providers = [new DummySmsProvider()];
        }
        return $providers[array_rand($providers)];
    }
}
