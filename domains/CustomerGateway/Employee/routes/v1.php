<?php
use Domains\CustomerGateway\Employee\Api\EmployeeHandler;

Route::group(['prefix'=> 'api/v1/employees', 'as' => 'api.employee'], function(){
    Route::get('/', [EmployeeHandler::class, 'show']);
    });