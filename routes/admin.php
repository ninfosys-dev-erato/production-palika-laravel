<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Src\Settings\Controllers\FiscalYearController;
use Src\Settings\Controllers\SettingController;

Route::middleware(['auth','web'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('dashboard', DashboardController::class)->name('dashboard');
        Route::any('logout', [AuthController::class, 'logout'])->name('logout');
        Route::view('form-sample', 'form-sample')->name('form-sample');
        Route::view('table-sample', 'table-sample')->name('table-sample');
    });

