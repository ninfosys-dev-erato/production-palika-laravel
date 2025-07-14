<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\TypeAdminController;

Route::group(['prefix' => 'admin/plan_management_system/types', 'as' => 'admin.types.', 'middleware' => ['web', 'auth','check_module:plan']], function () {
    Route::get('/', [TypeAdminController::class, 'index'])->name('index');
    Route::get('/create', [TypeAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [TypeAdminController::class, 'edit'])->name('edit');
});
