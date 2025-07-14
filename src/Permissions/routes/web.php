<?php

use Illuminate\Support\Facades\Route;
use \Src\Permissions\Controllers\PermissionAdminController;

Route::group(['prefix' =>'admin/permissions', 'as'=>'admin.permissions.','middleware'=>['web','auth'] ], function () {
    Route::get('/',[PermissionAdminController::class,'index'])->name('index')->middleware('permission:permissions_access');
    Route::get('/create',[PermissionAdminController::class,'create'])->name('create')->middleware('permission:permissions_create');
    Route::get('/edit/{id}',[PermissionAdminController::class,'edit'])->name('edit')->middleware('permission:permissions_update');
});
