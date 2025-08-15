<?php

use Illuminate\Support\Facades\Route;
use Src\Beruju\Controllers\ActionTypeAdminController;

Route::group(['prefix' => 'admin/beruju/action-types', 'as' => 'admin.beruju.action-types.', 'middleware' => ['web', 'auth', 'check_module:beruju']], function () {
    Route::get('/', [ActionTypeAdminController::class, 'index'])->name('index');
    Route::get('/create', [ActionTypeAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [ActionTypeAdminController::class, 'edit'])->name('edit');
    Route::get('/show/{id}', [ActionTypeAdminController::class, 'show'])->name('show');
});
