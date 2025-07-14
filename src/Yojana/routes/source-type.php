<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\SourceTypeAdminController;

Route::group(['prefix' => 'admin/plan_management_system/source_types', 'as' => 'admin.source_types.', 'middleware' => ['web', 'auth', 'check_module:plan']], function () {
    Route::get('/', [SourceTypeAdminController::class, 'index'])->name('index');
    Route::get('/create', [SourceTypeAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [SourceTypeAdminController::class, 'edit'])->name('edit');
});
