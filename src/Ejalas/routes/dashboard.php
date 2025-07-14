<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\DashboardAdminController;

Route::group(['prefix' => 'admin/ejalas/dashboard', 'as' => 'admin.dashboard.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/', [DashboardAdminController::class, 'dashboard'])->name('dashboard');
});
