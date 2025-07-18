<?php


use Domains\AdminGateway\StatusUpdate\Api\AdminStatusUpdateHandler;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api-user','setLocale'],'prefix'=>'api/v1/admin/status'], function () {
    Route::post('/',[AdminStatusUpdateHandler::class,'updateRecommendationStatus']);
});
