<?php

use Illuminate\Support\Facades\Route;
use Src\Beruju\Controllers\ActionAdminController;

Route::group(['prefix' => 'admin/beruju/actions', 'as' => 'admin.beruju.actions.', 'middleware' => ['web', 'auth', 'check_module:beruju']], function () {
    Route::get('/', [ActionAdminController::class, 'index'])->name('index');
    Route::get('/create', [ActionAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [ActionAdminController::class, 'edit'])->name('edit');
    Route::get('/show/{id}', [ActionAdminController::class, 'show'])->name('show');
});
