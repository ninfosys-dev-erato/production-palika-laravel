<?php
use \Src\GrantManagement\Controllers\FarmerGroupAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/grant-management/farmer-groups', 'as'=>'admin.farmer_groups.','middleware'=>['web','auth','check_module:grant'] ], function () {
    Route::get('/',[FarmerGroupAdminController::class,'index'])->name('index');
    Route::get('/create',[FarmerGroupAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[FarmerGroupAdminController::class,'edit'])->name('edit');
});
