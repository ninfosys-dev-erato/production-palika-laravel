<?php
use \Src\GrantManagement\Controllers\GrantOfficeAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/grant-management/grant-offices', 'as'=>'admin.grant_offices.','middleware'=>['web','auth','check_module:grant'] ], function () {
    Route::get('/',[GrantOfficeAdminController::class,'index'])->name('index');
    Route::get('/create',[GrantOfficeAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[GrantOfficeAdminController::class,'edit'])->name('edit');
});
