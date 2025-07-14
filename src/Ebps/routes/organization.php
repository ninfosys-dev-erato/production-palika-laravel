<?php

use \Src\Ebps\Controllers\OrganizationAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/ebps/organizations', 'as'=>'admin.ebps.organizations.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[OrganizationAdminController::class,'index'])->name('index');
    Route::get('/create',[OrganizationAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[OrganizationAdminController::class,'edit'])->name('edit');
    Route::get('/show/{id}',[OrganizationAdminController::class,'show'])->name('show');
    Route::post('/deactivate/{id}',[OrganizationAdminController::class,'deactivate'])->name('deactivate');
});
