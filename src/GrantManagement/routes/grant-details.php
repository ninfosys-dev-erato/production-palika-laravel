<?php
use \Src\GrantManagement\Controllers\GrantDetailAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/grant-management/grant-details', 'as'=>'admin.grant_details.','middleware'=>['web','auth','check_module:grant'] ], function () {
    Route::get('/',[GrantDetailAdminController::class,'index'])->name('index');
    Route::get('/create',[GrantDetailAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[GrantDetailAdminController::class,'edit'])->name('edit');
});
