<?php

use Illuminate\Support\Facades\Route;
use \Src\Roles\Controllers\RoleAdminController;

Route::group(['prefix' =>'admin/roles', 'as'=>'admin.roles.','middleware'=>['web','auth'] ], function () {
    Route::get('/',[RoleAdminController::class,'index'])->name('index')->middleware('permission:roles access');
    Route::get('/create',[RoleAdminController::class,'create'])->name('create')->middleware('permission:roles create');
    Route::get('/edit/{id}',[RoleAdminController::class,'edit'])->name('edit')->middleware('permission:roles update');
    Route::get('/manage',[RoleAdminController::class,'managePermissions'])->name('manage')->middleware('permission:roles manage');
});
