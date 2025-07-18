<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\ComplaintRegistrationAdminController;

Route::group(['prefix' => 'admin/complaint_registrations', 'as' => 'admin.ejalas.complaint_registrations.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/{from?}', [ComplaintRegistrationAdminController::class, 'index'])->name('index');
    Route::get('/create/{from?}', [ComplaintRegistrationAdminController::class, 'create'])->name('create');
    Route::get('/edit/{from?}/{id}', [ComplaintRegistrationAdminController::class, 'edit'])->name('edit');
    Route::get('/view/{id}', [ComplaintRegistrationAdminController::class, 'view'])->name('view');
    Route::get('/preview/{id}', [ComplaintRegistrationAdminController::class, 'preview'])->name('preview');
    // Route::get('/report', [ComplaintRegistrationAdminController::class, 'report'])->name('report');
    // Route::get('/reconciliation/index', [ComplaintRegistrationAdminController::class, 'reconciliationIndex'])->name('reconciliationIndex');
});

Route::group(['prefix' => 'admin/complaint_registrations', 'as' => 'admin.ejalas.report.complaint_registrations.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/report', [ComplaintRegistrationAdminController::class, 'report'])->name('report');
});

Route::group(['prefix' => 'admin/complaint_registrations', 'as' => 'admin.ejalas.reconciliation.complaint_registrations.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/reconciliation/index', [ComplaintRegistrationAdminController::class, 'reconciliationIndex'])->name('reconciliationIndex');
});


Route::group(['prefix' => 'admin/ejalas/fiscal_year', 'as' => 'admin.ejalas.fiscal_years.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/report', [ComplaintRegistrationAdminController::class, 'fiscalYearReport'])->name('report');
});
