<?php

use Frontend\CustomerPortal\CustomerKyc\Controllers\CustomerController;

Route::group(['middleware' => ['web', 'customer'], 'prefix' => 'customer/kyc', 'as' => 'customer.kyc.'], function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/create', [CustomerController::class, 'create'])
        ->name('create');
    Route::get('/show', [CustomerController::class, 'show'])->name('detail');
});