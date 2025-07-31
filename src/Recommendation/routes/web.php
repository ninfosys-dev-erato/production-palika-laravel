<?php

use Illuminate\Support\Facades\Route;
use Src\Grievance\Controllers\GrievanceDetailController;
use Src\Recommendation\Controllers\RecommendationDashboardController;
use Src\Recommendation\Controllers\ApplyRecommendationController;
use Src\Recommendation\Controllers\RecommendationCategoryController;
use Src\Recommendation\Controllers\RecommendationController;
use Src\Recommendation\Controllers\RecommendationFormTemplateController;
use Src\Settings\Controllers\FormController;

Route::group(['prefix' => 'admin/recommendations', 'as' => 'admin.recommendations.', 'middleware' => ['web', 'auth','check_module:recommendation']], function () {

    Route::get('/', [RecommendationDashboardController::class, 'index'])->name('dashboard')->middleware('permission:recommendation access');
    Route::get('/recommendation-category/', [RecommendationCategoryController::class, 'index'])->name('recommendation-category.index')->middleware('permission:recommendation_settings access');
    Route::get('/recommendation-category/create', [RecommendationCategoryController::class, 'create'])->name('recommendation-category.create')->middleware('permission:recommendation_settings create');
    Route::get('/recommendation-category/edit/{id}', [RecommendationCategoryController::class, 'edit'])->name('recommendation-category.edit')->middleware('permission:recommendation_settings update');

    Route::get('/recommendation/', [RecommendationController::class, 'index'])->name('recommendation.index')->middleware('permission:recommendation_settings access');
    Route::get('/recommendation/create', [RecommendationController::class, 'create'])->name('recommendation.create')->middleware('permission:recommendation_settings create');
    Route::get('/recommendation/edit/{id}', [RecommendationController::class, 'edit'])->name('recommendation.edit')->middleware('permission:recommendation_settings update');
    Route::get('/recommendation/manage/{id}', [RecommendationController::class, 'manage'])->name('recommendation.manage')->middleware('permission:recommendation_settings access');
    Route::get('/notification',[RecommendationController::class, 'notification'])->name('recommendation.notification')->middleware('permission:recommendation_settings access');

    Route::get('/form/', [RecommendationFormTemplateController::class, 'index'])->name('form-template.index')->middleware('permission:recommendation_settings access');
    Route::get('/form-template/create', [RecommendationFormTemplateController::class, 'create'])->name('form-template.create')->middleware('permission:recommendation_settings access');
    Route::get('/form/create', [FormController::class, 'create'])->name('form.create')->middleware('permission:recommendation_settings access');
    Route::get('/form/edit/{id}', [FormController::class, 'edit'])->name('form.edit')->middleware('permission:recommendation_settings access');
    Route::get('/form/template/{id}', [FormController::class, 'template'])->name('form.template')->middleware('permission:recommendation_settings access');


    Route::get('/apply-recommendation/', [ApplyRecommendationController::class, 'index'])->name('apply-recommendation.index')->middleware('permission:recommendation_apply access');
    Route::get('/apply-recommendation/create/{recommendation?}', [ApplyRecommendationController::class, 'create'])->name('apply-recommendation.create')->middleware('permission:recommendation_apply create');
    Route::get('/apply-recommendation/edit/{id}', [ApplyRecommendationController::class, 'edit'])->name('apply-recommendation.edit')->middleware('permission:recommendation_apply update');
    Route::get('/apply-recommendation/{applyRecommendation}', [ApplyRecommendationController::class, 'show'])->name('apply-recommendation.show')->middleware('permission:recommendation_apply access');
    Route::get('/report', [ApplyRecommendationController::class, 'report'])->name('report')->middleware('permission:recommendation_apply access');
    Route::get('/export',[ApplyRecommendationController::class, 'export'])->name('export');
    Route::get('/download-pdf',[ApplyRecommendationController::class, 'downloadPdf'])->name('download-pdf');
    Route::get('/register/{id}', [ApplyRecommendationController::class, 'register'])->name('recommendation.register');
    Route::get('/preview/{id}', [ApplyRecommendationController::class, 'preview'])->name('preview');
});
    Route::get('/customers/search', [ApplyRecommendationController::class, 'search'])->name('customers.search');
