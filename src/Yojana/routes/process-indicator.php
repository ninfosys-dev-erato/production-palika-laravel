<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ProcessIndicatorAdminController;

Route::group(['prefix' => 'admin/plan_management_system/process_indicators', 'as' => 'admin.process_indicators.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', [ProcessIndicatorAdminController::class, 'index'])->name('index');
    Route::get('/create', [ProcessIndicatorAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [ProcessIndicatorAdminController::class, 'edit'])->name('edit');
});
