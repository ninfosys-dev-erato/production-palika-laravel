<?php

namespace App\Facades;
use Illuminate\Support\Facades\Facade;
class PdfFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'pdf-service';
    }
}