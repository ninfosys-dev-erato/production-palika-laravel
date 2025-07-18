<?php

use \Src\ActivityLogs\Controllers\ActivityLogAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/activity_logs', 'as' => 'admin.activity_logs.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', [ActivityLogAdminController::class, 'index'])->name('index');
    Route::get('/create', [ActivityLogAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [ActivityLogAdminController::class, 'edit'])->name('edit');
    Route::get('/view/{id}', [ActivityLogAdminController::class, 'show'])->name('show');
});
