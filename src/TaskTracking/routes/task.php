<?php

use Src\TaskTracking\Controllers\TaskTrackingDashboardController;
use \Src\TaskTracking\Controllers\TaskAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/tasks', 'as' => 'admin.tasks.', 'middleware' => ['web', 'auth', 'check_module:task_tracking']], function () {
    Route::get('/', [TaskAdminController::class, 'index'])->name('index');
    Route::get('/create', [TaskAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [TaskAdminController::class, 'edit'])->name('edit');
    Route::get('/view/{id}', [TaskAdminController::class, 'view'])->name('view');
});
Route::group(['prefix' => 'admin/task-tracking', 'as' => 'admin.task-tracking.', 'middleware' => ['web', 'auth', 'check_module:task_tracking']], function () {
    Route::get('/', [TaskTrackingDashboardController::class, 'index'])->name('index');
});
