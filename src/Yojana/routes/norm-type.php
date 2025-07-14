<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\NormTypeAdminController;

Route::group(['prefix' => 'admin/plan_management_system/norm-types', 'as' => 'admin.norm_types.', 'middleware' => ['web', 'auth', 'check_module:plan']], function () {
    Route::get('/', [NormTypeAdminController::class, 'index'])->name('index');
    Route::get('/create', [NormTypeAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [NormTypeAdminController::class, 'edit'])->name('edit');
});
