<?php
use \Src\GrantManagement\Controllers\GrantReleaseAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/grant-management/grant-release', 'as' => 'admin.grant_release.', 'middleware' => ['web', 'auth', 'check_module:grant']], function () {
    Route::get('/', [GrantReleaseAdminController::class, 'index'])->name('index');
    Route::get('/create',[GrantReleaseAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[GrantReleaseAdminController::class,'edit'])->name('edit');
    Route::get('/show/{id}',[GrantReleaseAdminController::class,'show'])->name('show');
});

Route::group(['prefix' => 'admin/grant-management/reports', 'as' => 'admin.reports.grant_release.', 'middleware' => ['web', 'auth', 'check_module:grant']], function () {
    Route::get('/grant-release', [GrantReleaseAdminController::class, 'reports'])->name('reports');
});