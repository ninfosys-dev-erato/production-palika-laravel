<?php

use Domains\CustomerGateway\EmergencyContact\Api\EmergencyContactHandler;

Route::group(['prefix'=> 'api/v1/emergency-contact', 'as' => 'api.emergency-contact', 'middleware'=> 'auth:api-customer'], function(){
    Route::get('/', [EmergencyContactHandler::class, 'show']);
    });