<?php

use Domains\CustomerGateway\EmergencyContact\Api\v2\EmergencyContactHandler;

Route::group(['prefix'=> 'api/v2/emergency-contact', 'as' => 'api.emergency-contact', 'middleware'=> 'auth:api-customer'], function(){
    Route::get('/', [EmergencyContactHandler::class, 'show']);
    Route::get('/service/{id}', [EmergencyContactHandler::class, 'showDetail'])->name('showDetail');
    });