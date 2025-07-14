<?php
use \Src\GrantManagement\Controllers\CashGrantAdminController;
use Src\GrantManagement\Controllers\CashGrantReportsAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/grant-management/cash-grants', 'as' => 'admin.cash_grants.', 'middleware' => ['web', 'auth', 'check_module:grant']], function () {
    Route::get('/', [CashGrantAdminController::class, 'index'])->name('index');
    Route::get('/create', [CashGrantAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [CashGrantAdminController::class, 'edit'])->name('edit');
    Route::get('/show/{id}', [CashGrantAdminController::class, 'show'])->name('show');
});

Route::group(['prefix' => 'admin/grant-management/reports', 'as' => 'admin.reports.cash_grant.', 'middleware' => ['web', 'auth', 'check_module:grant']], function () {
    Route::get('/cash-grant', [CashGrantAdminController::class, 'reports'])->name('reports');
});
