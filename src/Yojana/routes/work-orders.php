<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\WorkOrderAdminController;

Route::group(['prefix' => 'admin/plan/work-orders', 'as' => 'admin.plans.work_orders.', 'middleware' => ['web', 'auth','check_module:plan']], function () {
    Route::get('/', [WorkOrderAdminController::class, 'index'])->name('index');
    Route::get('/create/{plan_id}', [WorkOrderAdminController::class, 'create'])->name('create');
    Route::get('/preview/{id}', [WorkOrderAdminController::class, 'preview'])->name('preview');
});
