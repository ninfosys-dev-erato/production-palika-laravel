<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\PlanAreaAdminController;

Route::group(['prefix' => 'admin/plan_management_system/plan-areas', 'as' => 'admin.plan_areas.', 'middleware' => ['web', 'auth', 'check_module:plan']], function () {
    Route::get('/', [PlanAreaAdminController::class, 'index'])->name('index');
    Route::get('/create', [PlanAreaAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [PlanAreaAdminController::class, 'edit'])->name('edit');
});
