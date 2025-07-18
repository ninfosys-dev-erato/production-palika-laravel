<?php

use Illuminate\Support\Facades\Route;
use Frontend\CustomerPortal\BusinessRegistrationAndRenewal\Controllers\BusinessRegistrationAdminController;
use Frontend\CustomerPortal\BusinessRegistrationAndRenewal\Controllers\BusinessRenewalAdminController;

Route::group(['prefix' => 'customer/business-registration-system', 'as' => 'customer.business-registration.', 'middleware' => ['web', 'customer']], function () {

    Route::group(['prefix' => 'business-registration', 'as' => 'business-registration.', 'middleware' => ['web', 'customer']], function () {
        Route::get('/', [BusinessRegistrationAdminController::class, 'index'])->name('index');
        Route::get('/create', [BusinessRegistrationAdminController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [BusinessRegistrationAdminController::class, 'edit'])->name('edit');
        Route::get('/show/{id}', [BusinessRegistrationAdminController::class, 'view'])->name('show');
    });

    Route::group(['prefix' => 'renewals', 'as' => 'renewals.', 'middleware' => ['web', 'customer']], function () {
        Route::get('/', [BusinessRenewalAdminController::class, 'index'])->name('index');
        Route::get('/show/{id}', [BusinessRenewalAdminController::class, 'view'])->name('show');
    });
});
