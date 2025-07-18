<?php

use Domains\CustomerGateway\Notification\Api\NotificationHandler;

Route::group(['prefix'=> 'api/v1/notification', 'as' => 'api.notification.', 'middleware'=> ['auth:api-customer', 'setLocale']], function(){
    Route::post('send', [NotificationHandler::class, 'send']);
});