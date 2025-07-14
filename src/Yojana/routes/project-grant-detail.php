<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ProjectGrantDetailAdminController;

Route::group(['prefix' =>'admin/project_grant_details', 'as'=>'admin.project_grant_details.','middleware'=>['web','auth', 'check_module:plan'] ], function () {
    Route::get('/',[ProjectGrantDetailAdminController::class,'index'])->name('index');
    Route::get('/create',[ProjectGrantDetailAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ProjectGrantDetailAdminController::class,'edit'])->name('edit');
});
