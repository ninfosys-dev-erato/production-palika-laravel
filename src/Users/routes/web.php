<?php

use Illuminate\Support\Facades\Route;
use \Src\Users\Controllers\UserAdminController;

Route::group(['prefix' => 'admin/users', 'as' => 'admin.users.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', [UserAdminController::class, 'index'])->name('index')->middleware('permission:users access');
    Route::get('/create', [UserAdminController::class, 'create'])->name('create')->middleware('permission:users create');
    Route::get('/edit/{id}', [UserAdminController::class, 'edit'])->name('edit')->middleware('permission:users edit');
    Route::get('/role/{id}', [UserAdminController::class, 'roles'])->name('role')->middleware('permission:users manage');
    Route::get('/permission/{id}', [UserAdminController::class, 'permissions'])->name('permission')->middleware('permission:users manage');
    Route::get('manage/{id}', [UserAdminController::class, 'manage'])->name('manage')->middleware('permission:users manage');
});
