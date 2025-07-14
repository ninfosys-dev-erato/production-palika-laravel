<?php
use Domains\CustomerGateway\CustomerDetail\Api\CustomerAvatarHandler;
use Domains\CustomerGateway\CustomerDetail\Api\CustomerDetailHandler;

Route::group(['prefix'=> 'api/v1/customers', 'as' => 'api.customer.', 'middleware'=>[ 'auth:api-customer', 'setLocale']], function(){
    Route::get('/', [CustomerDetailHandler::class, 'show']);   
    Route::get('/notification-preference', [CustomerDetailHandler::class, 'showNotificationPreference']);   
    Route::post('/avatar', [CustomerAvatarHandler::class, 'avatar']);   
    });