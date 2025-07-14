<?php
use Domains\CustomerGateway\Branch\Api\BranchHandler;

Route::group(['prefix'=> 'api/v1/branches', 'as' => 'api.branch.', 'middleware'=> ['auth:api-customer']], function(){
    
    Route::get('/', [BranchHandler::class, 'getBranches']);
    });