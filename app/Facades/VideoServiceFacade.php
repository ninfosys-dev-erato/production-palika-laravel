<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class VideoServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'video-service';
    }
}
