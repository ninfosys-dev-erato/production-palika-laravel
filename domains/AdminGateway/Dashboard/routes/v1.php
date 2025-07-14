<?php


use Domains\AdminGateway\Dashboard\Api\AdminDashboardHandler;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api-user','setLocale'],'prefix'=>'api/v1/admin/dashboard'], function () {
    Route::get('/',[AdminDashboardHandler::class,'dashboardCounts']);
});
