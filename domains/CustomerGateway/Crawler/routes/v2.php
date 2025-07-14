<?php

use Domains\CustomerGateway\Crawler\Api\WebsiteHandler;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=> 'api/v2/crawler'], function(){
    Route::get('/',[WebsiteHandler::class,'getData']);
    Route::get('/downloads',[WebsiteHandler::class,'downloads']);
});
