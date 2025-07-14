<?php

use \Src\FuelSettings\Controllers\FuelSettingAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/fuel_settings', 'as' => 'admin.fuel_settings.', 'middleware' => ['web', 'auth', 'check_module:fuel']], function () {
    Route::get('/', [FuelSettingAdminController::class, 'index'])->name('index');
    Route::get('/create', [FuelSettingAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [FuelSettingAdminController::class, 'edit'])->name('edit');
});

Route::group(['prefix' => 'admin/fuel', 'as' => 'admin.fuel.', 'middleware' => ['web', 'auth', 'check_module:fuel']], function () {
    Route::get('/dashboard', [FuelSettingAdminController::class, 'dashboard'])->name('dashboard');
});
