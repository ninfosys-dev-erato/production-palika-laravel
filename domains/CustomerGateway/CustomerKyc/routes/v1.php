<?php

use Domains\CustomerGateway\CustomerKyc\Api\CustomerKycHandler;
use Domains\CustomerGateway\CustomerKyc\Api\LocationHandler;

Route::group(['prefix'=> 'api/v1/customer-kyc', 'as' => 'api.customer-kyc.', 'middleware'=> ['auth:api-customer', 'setLocale']], function(){
    Route::post('submit', [CustomerKycHandler::class, 'store']);
    Route::patch('submit', [CustomerKycHandler::class, 'update']);
});