<?php

use Domains\CustomerGateway\Crawler\Api\CrawlerHandler;
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=> 'api/v1/crawler', 'as' => 'api.crawler.'], function(){
    Route::get('/',[CrawlerHandler::class,'getWebsiteData'])->name('get-website-data');
});
