<?php


use Domains\CustomerGateway\Location\Api\GetAllDistrict;
use Domains\CustomerGateway\Location\Api\LocationHandler;

Route::group(['prefix'=> 'api/v1/location', 'as' => 'api.customer-kyc.', 'middleware'=> 'auth:api-customer'], function(){    
    Route::get('get-provinces', [LocationHandler::class, 'getProvince']);
    Route::get('get-districts', [LocationHandler::class, 'getDistrict']);
    Route::get('get-local-bodies', [LocationHandler::class, 'getLocalBodies']);
    Route::get('get-all-districts', [GetAllDistrict::class, 'getAllDistricts']);
    Route::get('get-wards', [LocationHandler::class, 'getWards']);
    });