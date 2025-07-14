<?php
use \Src\GrantManagement\Controllers\EnterpriseAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/grant-management/enterprises', 'as' => 'admin.enterprises.', 'middleware' => ['web', 'auth', 'check_module:grant']], function () {
    Route::get('/', [EnterpriseAdminController::class, 'index'])->name('index');
    Route::get('/create', [EnterpriseAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [EnterpriseAdminController::class, 'edit'])->name('edit');
    Route::get('/show/{id}', [EnterpriseAdminController::class, 'show'])->name('show');
});

Route::group(['prefix' => 'admin/grant-management/reports', 'as' => 'admin.reports.enterprises.', 'middleware' => ['web', 'auth', 'check_module:grant']], function () {
    Route::get('/enterprises', [EnterpriseAdminController::class, 'reports'])->name('reports');
});
