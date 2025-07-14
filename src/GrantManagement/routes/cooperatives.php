<?php
use \Src\GrantManagement\Controllers\CooperativeAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/grant-management/cooperative', 'as' => 'admin.cooperative.', 'middleware' => ['web', 'auth', 'check_module:grant']], function () {
    Route::get('/', [CooperativeAdminController::class, 'index'])->name('index');
    Route::get('/create', [CooperativeAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [CooperativeAdminController::class, 'edit'])->name('edit');
    Route::get('/show/{id}', [CooperativeAdminController::class, 'show'])->name('show');
});

Route::group(['prefix' => 'admin/grant-management/reports', 'as' => 'admin.reports.cooperative.', 'middleware' => ['web', 'auth', 'check_module:grant']], function () {
    Route::get('/cooperative', [CooperativeAdminController::class, 'reports'])->name('reports');
});