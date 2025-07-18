<?php
use \Src\GrantManagement\Controllers\EnterpriseFarmerAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/grant-management/enterprise-farmers', 'as'=>'admin.enterprise_farmers.','middleware'=>['web','auth','check_module:grant'] ], function () {
    Route::get('/',[EnterpriseFarmerAdminController::class,'index'])->name('index');
    Route::get('/create',[EnterpriseFarmerAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[EnterpriseFarmerAdminController::class,'edit'])->name('edit');
});
