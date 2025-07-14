<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class GlobalFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'global-service';
    }
}