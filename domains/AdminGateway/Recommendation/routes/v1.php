<?php

use Domains\AdminGateway\Recommendation\Api\AdminApplyRecommendationHandler;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth:api-user', 'setLocale'], 'prefix' => 'api/v1/admin/recommendation'], function () {
    Route::get('/', [AdminApplyRecommendationHandler::class, 'index'])
        ->middleware('permission:recommendation access');
});