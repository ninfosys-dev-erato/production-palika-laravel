<?php

use Domains\CustomerGateway\Recommendation\Api\RecommendationHandler;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/v1/recommendation', 'as' => 'api.recommendation.', 'middleware' => ['auth:api-customer', 'setLocale']], function () {
    Route::post('/apply', [RecommendationHandler::class, 'create'])->middleware('checkKycVerification');;
    Route::patch('/apply/{id}', [RecommendationHandler::class, 'update']);
    Route::get('/applied-recommendations', [RecommendationHandler::class, 'getAppliedRecommendations']);
    Route::get('/recommendation-category', [RecommendationHandler::class, 'getRecommendationCategory']);
    Route::get('/recommendations/{id}', [RecommendationHandler::class, 'getRecommendations']);
    Route::get('/recommendation-form/{id}', [RecommendationHandler::class, 'getRecommendationsForm']);
    Route::get('/applied-recommendation/{id}', [RecommendationHandler::class, 'getAppliedRecommendationDetail']);
    Route::post('/upload-bill/{id}', [RecommendationHandler::class, 'uploadBill'] );
    Route::post('/send-to-approver/{id}', [RecommendationHandler::class, 'sendToApprover'] );
    Route::get('/letter/{id}', [RecommendationHandler::class, 'getletter'] );
});

