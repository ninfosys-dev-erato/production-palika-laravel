<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\PlanLevelAdminController;

Route::group(['prefix' => 'admin/plan_management_system/plan_levels', 'as' => 'admin.plan_levels.', 'middleware' => ['web', 'auth', 'check_module:plan']], function () {
    Route::get('/', [PlanLevelAdminController::class, 'index'])->name('index');
    Route::get('/create', [PlanLevelAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [PlanLevelAdminController::class, 'edit'])->name('edit');
});
