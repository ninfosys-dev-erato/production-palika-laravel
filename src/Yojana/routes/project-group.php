<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ProjectGroupAdminController;

Route::group(['prefix' => 'admin/plan_management_system/project_groups', 'as' => 'admin.project_groups.', 'middleware' => ['web', 'auth', 'check_module:plan']], function () {
    Route::get('/', [ProjectGroupAdminController::class, 'index'])->name('index');
    Route::get('/create', [ProjectGroupAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [ProjectGroupAdminController::class, 'edit'])->name('edit');
});
