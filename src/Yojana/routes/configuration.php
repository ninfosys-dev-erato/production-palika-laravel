<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ConfigurationAdminController;

Route::group(['prefix' => 'admin/plan_management_system/configurations', 'as' => 'admin.configurations.', 'middleware' => ['web', 'auth', 'check_module:plan']], function () {
    Route::get('/', [ConfigurationAdminController::class, 'index'])->name('index');
    Route::get('/create', [ConfigurationAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [ConfigurationAdminController::class, 'edit'])->name('edit');
});
