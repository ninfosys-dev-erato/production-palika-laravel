<?php

use Illuminate\Support\Facades\Route;
use \Src\Roles\Controllers\RoleAdminController;

Route::group(['prefix' =>'admin/roles', 'as'=>'admin.roles.','middleware'=>['web','auth'] ], function () {
    Route::get('/',[RoleAdminController::class,'index'])->name('index')->middleware('permission:roles_access');
    Route::get('/create',[RoleAdminController::class,'create'])->name('create')->middleware('permission:roles_create');
    Route::get('/edit/{id}',[RoleAdminController::class,'edit'])->name('edit')->middleware('permission:roles_update');
    Route::get('/manage',[RoleAdminController::class,'managePermissions'])->name('manage')->middleware('permission:roles_manage');
});
