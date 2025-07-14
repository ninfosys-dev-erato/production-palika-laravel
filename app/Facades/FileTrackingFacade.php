<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class FileTrackingFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'file-tracking-service';
    }
}