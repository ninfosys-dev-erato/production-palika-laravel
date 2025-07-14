<?php
use \Src\GrantManagement\Controllers\GrantTypeAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/grant-management/grant-types', 'as'=>'admin.grant_types.','middleware'=>['web','auth','check_module:grant'] ], function () {
    Route::get('/',[GrantTypeAdminController::class,'index'])->name('index');
    Route::get('/create',[GrantTypeAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[GrantTypeAdminController::class,'edit'])->name('edit');
});
