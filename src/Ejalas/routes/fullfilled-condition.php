<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\FulfilledConditionAdminController;

Route::group(['prefix' => 'admin/ejalas/fulfilled_conditions', 'as' => 'admin.ejalas.fulfilled_conditions.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/{from?}', [FulfilledConditionAdminController::class, 'index'])->name('index');
    Route::get('/create/{from?}', [FulfilledConditionAdminController::class, 'create'])->name('create');
    Route::get('/edit/{from?}/{id}', [FulfilledConditionAdminController::class, 'edit'])->name('edit');
    Route::get('/preview/{id}', [FulfilledConditionAdminController::class, 'preview'])->name('preview');
    Route::get('/report', [FulfilledConditionAdminController::class, 'report'])->name('report');
    // Route::get('/reconciliation/index', [FulfilledConditionAdminController::class, 'reconciliationIndex'])->name('reconciliationIndex');
});
Route::group(['prefix' => 'admin/ejalas/fulfilled_conditions', 'as' => 'admin.ejalas.report.fulfilled_conditions.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/fulfilled_conditions/report', [FulfilledConditionAdminController::class, 'report'])->name('report');
});

Route::group(['prefix' => 'admin/ejalas/fulfilled_conditions', 'as' => 'admin.ejalas.reconciliation.fulfilled_conditions.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/reconciliation/index', [FulfilledConditionAdminController::class, 'reconciliationIndex'])->name('reconciliationIndex');
});
