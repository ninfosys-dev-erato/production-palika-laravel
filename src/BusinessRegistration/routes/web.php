<?php

use Illuminate\Support\Facades\Route;
use Src\BusinessRegistration\Controllers\BusinessDeRegistrationAdminController;
use Src\BusinessRegistration\Controllers\BusinessNatureAdminController;
use Src\BusinessRegistration\Controllers\BusinessRegistrationAdminController;
use Src\BusinessRegistration\Controllers\BusinessRegistrationDashboardController;
use Src\BusinessRegistration\Controllers\BusinessRegistrationFormTemplateController;
use Src\BusinessRegistration\Controllers\BusinessRenewalAdminController;
use Src\BusinessRegistration\Controllers\RegistrationCategoryAdminController;
use Src\BusinessRegistration\Controllers\RegistrationTypeAdminController;
use Src\Settings\Controllers\FormController;

Route::group(['prefix' => 'admin/business-registration-system', 'as' => 'admin.business-registration.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', [BusinessRegistrationDashboardController::class, 'index'])->name('index');
    Route::get('/register/{id}', [RegistrationCategoryAdminController::class, 'register'])->name('business.register');

    Route::group(['prefix' => 'registration-category', 'as' => 'registration-category.', 'middleware' => ['web', 'auth']], function () {
        Route::get('/', [RegistrationCategoryAdminController::class, 'index'])->name('index');
        Route::get('/create', [RegistrationCategoryAdminController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [RegistrationCategoryAdminController::class, 'edit'])->name('edit');
    });

    Route::group(['prefix' => 'business-nature', 'as' => 'business-nature.', 'middleware' => ['web', 'auth']], function () {
        Route::get('/', [BusinessNatureAdminController::class, 'index'])->name('index');
        Route::get('/create', [BusinessNatureAdminController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [BusinessNatureAdminController::class, 'edit'])->name('edit');
    });

    Route::group(['prefix' => 'registration-types', 'as' => 'registration-types.', 'middleware' => ['web', 'auth']], function () {
        Route::get('/', [RegistrationTypeAdminController::class, 'index'])->name('index');
        Route::get('/create', [RegistrationTypeAdminController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [RegistrationTypeAdminController::class, 'edit'])->name('edit');
    });

    Route::group(['prefix' => 'business-registration', 'as' => 'business-registration.', 'middleware' => ['web', 'auth']], function () {
        Route::get('/', [BusinessRegistrationAdminController::class, 'index'])->name('index');
        Route::get('/create/{registration?}', [BusinessRegistrationAdminController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [BusinessRegistrationAdminController::class, 'edit'])->name('edit');
        Route::get('/show/{id}', [BusinessRegistrationAdminController::class, 'view'])->name('show');
        Route::get('/preview/{id}', [BusinessRegistrationAdminController::class, 'preview'])->name('preview');
        Route::get('/ownership-transfer/{id}', [BusinessRegistrationAdminController::class, 'ownershipTransfer'])->name('ownership-transfer');
    });

    Route::group(['prefix' => 'renewals', 'as' => 'renewals.', 'middleware' => ['web', 'auth']], function () {
        Route::get('/', [BusinessRenewalAdminController::class, 'index'])->name('index');
        Route::get('/create', [BusinessRenewalAdminController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [BusinessRenewalAdminController::class, 'edit'])->name('edit');
        Route::get('/show/{id}', [BusinessRenewalAdminController::class, 'view'])->name('show');
    });
    Route::get('/report', [BusinessRegistrationDashboardController::class, 'report'])->name('report');
    Route::get('/renewal-report', [BusinessRegistrationDashboardController::class, 'renewalReport'])->name('renewal-report');
});


Route::group(['prefix' => 'admin/business-registration', 'as' => 'admin.business-registration.', 'middleware' => ['web', 'auth']], function () {

    //    Form Template
    Route::get('/form/', [BusinessRegistrationFormTemplateController::class, 'index'])->name('form-template.index');
    Route::get('/form-template/create', [BusinessRegistrationFormTemplateController::class, 'create'])->name('form-template.create');
    Route::get('/form/create', [FormController::class, 'create'])->name('form.create');
    Route::get('/form/edit/{id}', [FormController::class, 'edit'])->name('form.edit');
    Route::get('/form/template/{id}', [FormController::class, 'template'])->name('form.template');
});


//degenerate business route line
Route::group(['prefix' => 'admin/business-de-registration', 'as' => 'admin.business-deregistration.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', [BusinessDeRegistrationAdminController::class, 'index'])->name('index');
    Route::get('/create', [BusinessDeRegistrationAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [BusinessDeRegistrationAdminController::class, 'edit'])->name('edit');
    Route::get('/show/{id}', [BusinessDeRegistrationAdminController::class, 'show'])->name('show');
    Route::get('/preview/{id}', [BusinessDeRegistrationAdminController::class, 'preview'])->name('preview');
});
