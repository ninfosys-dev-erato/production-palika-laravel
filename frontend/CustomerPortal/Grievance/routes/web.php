<?php

use Frontend\CustomerPortal\Grievance\Controllers\CustomerGrievanceController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web','customer'], 'prefix' => 'customer/grievances', 'as' => 'customer.grievance.'], function () {
    Route::get('/', [CustomerGrievanceController::class, 'index'])->name('index');
    Route::get('/create', [CustomerGrievanceController::class, 'create'])
        ->name('create');
    Route::get('/grievanceDetail/{grievanceDetail}', [CustomerGrievanceController::class, 'show'])
        ->name('show');
});