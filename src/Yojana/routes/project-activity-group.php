<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ProjectActivityGroupAdminController;

Route::group(['prefix' => 'admin/plan_management_system/project_activity_groups', 'as' => 'admin.project_activity_groups.', 'middleware' => ['web', 'auth', 'check_module:plan']], function () {
    Route::get('/', [ProjectActivityGroupAdminController::class, 'index'])->name('index');
    Route::get('/create', [ProjectActivityGroupAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [ProjectActivityGroupAdminController::class, 'edit'])->name('edit');
});
