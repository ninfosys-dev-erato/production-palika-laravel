<?php
use \Src\GrantManagement\Controllers\GrantProgramAdminController;
use Illuminate\Support\Facades\Route;
use Src\GrantManagement\Controllers\GrantProgramReportsAdminController;

Route::group(['prefix' => 'admin/grant-management/grant-programs', 'as' => 'admin.grant_programs.', 'middleware' => ['web', 'auth', 'check_module:grant']], function () {
    Route::get('/', [GrantProgramAdminController::class, 'index'])->name('index');
    Route::get('/create', [GrantProgramAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [GrantProgramAdminController::class, 'edit'])->name('edit');
    Route::get('/show/{id}', [GrantProgramAdminController::class, 'show'])->name('show');
});

Route::group(['prefix' => 'admin/grant-management/reports', 'as' => 'admin.reports.grant_programs.', 'middleware' => ['web', 'auth', 'check_module:grant']], function () {
    Route::get('/grant-programs', [GrantProgramAdminController::class, 'reports'])->name('reports');
});