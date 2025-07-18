<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\TargetAdminController;

Route::group(['prefix' =>'admin/plan_management_system/targets', 'as'=>'admin.targets.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[TargetAdminController::class,'index'])->name('index');
    Route::get('/create',[TargetAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[TargetAdminController::class,'edit'])->name('edit');
});
