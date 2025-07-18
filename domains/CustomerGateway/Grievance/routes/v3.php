<?php

use Domains\CustomerGateway\Grievance\Api\v3\GrievanceHandler;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'api/v3/grievances', 'as' => 'api.grievance.', 'middleware' => ['auth:api-customer', 'setLocale' , 'checkKycVerification']], function () {
    Route::post('/submit', [GrievanceHandler::class, 'create']);
});


