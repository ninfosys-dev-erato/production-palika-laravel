<?php

use Illuminate\Support\Facades\Route;
use Frontend\CustomerPortal\Recommendation\Controllers\CustomerApplyRecommendationController;


Route::group(['prefix' => 'customer/recommendations', 'as' => 'customer.recommendations.', 'middleware' => ['web','customer']], function () {
    Route::get('/apply-recommendation/', [CustomerApplyRecommendationController::class, 'index'])->name('apply-recommendation.index');
    Route::get('/apply-recommendation/create/{recommendation?}', [CustomerApplyRecommendationController::class, 'create'])->name('apply-recommendation.create');
    Route::get('/apply-recommendation/edit/{id}', [CustomerApplyRecommendationController::class, 'edit'])->name('apply-recommendation.edit');
    Route::get('/apply-recommendation/{applyRecommendation}', [CustomerApplyRecommendationController::class, 'show'])
        ->name('apply-recommendation.show');
});