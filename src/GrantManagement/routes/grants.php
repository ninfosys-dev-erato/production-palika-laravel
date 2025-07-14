<?php
use \Src\GrantManagement\Controllers\GrantAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/grant-management/grants', 'as'=>'admin.grants.','middleware'=>['web','auth','check_module:grant'] ], function () {
    Route::get('/',[GrantAdminController::class,'index'])->name('index');
    Route::get('/create',[GrantAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[GrantAdminController::class,'edit'])->name('edit');
});
