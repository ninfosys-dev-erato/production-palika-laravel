<?php

use Domains\AdminGateway\BusinessRegistration\Api\BusinessRegistrationHandler;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api-user', 'setLocale'], 'prefix' => 'api/v1/admin/business-registration'], function () {
    Route::get('/', [BusinessRegistrationHandler::class, 'index'])
        ->middleware('permission:business_registration_access');;
});