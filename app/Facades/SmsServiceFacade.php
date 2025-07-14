<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SmsServiceFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'sms-service';
    }
}
