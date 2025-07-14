<?php

use Frontend\CustomerPortal\Home\Controllers\HomeController;

Route::group(['middleware' => ['web'], 'as' => 'customer.home.'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/grievances', [HomeController::class, 'grievance'])
        ->name('grievance-list');

    Route::get('/show/{id}', [HomeController::class, 'showComplaintDetail'])->name('show');
    Route::get('/token-feedback', [HomeController::class, 'tokenFeedback'])->name('token-feedback');
   
});

