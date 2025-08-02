<?php

use \Src\TaskTracking\Controllers\TaskTypeAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/task-types', 'as' => 'admin.task-types.', 'middleware' => ['web', 'auth', 'check_module:task_tracking']], function () {
    Route::get('/', [TaskTypeAdminController::class, 'index'])->name('index');
    Route::get('/create', [TaskTypeAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [TaskTypeAdminController::class, 'edit'])->name('edit');
});
