<?php
use \Src\GrantManagement\Controllers\EnterpriseTypeAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/grant-management/enterprise-types', 'as'=>'admin.enterprise_types.','middleware'=>['web','auth','check_module:grant'] ], function () {
    Route::get('/',[EnterpriseTypeAdminController::class,'index'])->name('index');
    Route::get('/create',[EnterpriseTypeAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[EnterpriseTypeAdminController::class,'edit'])->name('edit');
});
