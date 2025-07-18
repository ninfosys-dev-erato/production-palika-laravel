<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\SettlementAdminController;

Route::group(['prefix' => 'admin/ejalas/settlements', 'as' => 'admin.ejalas.settlements.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/{from?}', [SettlementAdminController::class, 'index'])->name('index');
    Route::get('/create/{from?}', [SettlementAdminController::class, 'create'])->name('create');
    Route::get('/edit/{from?}/{id}', [SettlementAdminController::class, 'edit'])->name('edit');
    Route::get('/preview/{id}', [SettlementAdminController::class, 'preview'])->name('preview');
    // Route::get('/report', [SettlementAdminController::class, 'report'])->name('report');
    // Route::get('/reconciliation/index', [SettlementAdminController::class, 'reconciliationIndex'])->name('reconciliationIndex');
});
Route::group(['prefix' => 'admin/ejalas/settlements', 'as' => 'admin.ejalas.report.settlements.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/report', [SettlementAdminController::class, 'report'])->name('report');
});
Route::group(['prefix' => 'admin/settlements', 'as' => 'admin.ejalas.reconciliation.settlements.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/reconciliation/index', [SettlementAdminController::class, 'reconciliationIndex'])->name('reconciliationIndex');
});
