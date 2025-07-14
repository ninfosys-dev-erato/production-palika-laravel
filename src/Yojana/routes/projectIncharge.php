<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ProjectInchargeAdminController;

Route::group(['prefix' =>'admin/plan_management_system/project-incharge', 'as'=>'admin.project_incharge.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[ProjectInchargeAdminController::class,'index'])->name('index');
    Route::get('/create',[ProjectInchargeAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ProjectInchargeAdminController::class,'edit'])->name('edit');
});
