<?php
use Domains\CustomerGateway\Downloads\Api\DownloadHandler;

Route::group(['prefix'=> 'api/v1/downloads', 'as' => 'api.downloads', 'middleware'=> 'auth:api-customer'], function(){
    Route::get('/', [DownloadHandler::class, 'show']);
    });