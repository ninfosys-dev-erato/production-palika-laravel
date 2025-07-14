<?php

namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class HttpFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'http-service';
    }
}