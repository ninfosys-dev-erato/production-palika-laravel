<?php
use \Src\GrantManagement\Controllers\CooperativeTypeAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/grant-management/cooperative-types', 'as'=>'admin.cooperative_types.','middleware'=>['web','auth','check_module:grant'] ], function () {
    Route::get('/',[CooperativeTypeAdminController::class,'index'])->name('index');
    Route::get('/create',[CooperativeTypeAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[CooperativeTypeAdminController::class,'edit'])->name('edit');
});
