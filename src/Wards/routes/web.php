<?php

use \Src\Wards\Controllers\WardAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/wards', 'as' => 'admin.wards.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', [WardAdminController::class, 'index'])->name('index');
    Route::get('/create', [WardAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [WardAdminController::class, 'edit'])->name('edit');
    Route::get('/delete/{id}', [WardAdminController::class, 'destroy'])->name('destroy');
    Route::get('/showusers/{id}', [WardAdminController::class, 'showUsers'])->name('showusers');
});
