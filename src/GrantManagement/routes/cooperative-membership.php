<?php
use \Src\GrantManagement\Controllers\CooperativeFarmerAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/grant-management/cooperative-membership', 'as'=>'admin.cooperative_membership.','middleware'=>['web','auth','check_module:grant'] ], function () {
    Route::get('/',[CooperativeFarmerAdminController::class,'index'])->name('index');
    Route::get('/create',[CooperativeFarmerAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[CooperativeFarmerAdminController::class,'edit'])->name('edit');
});
