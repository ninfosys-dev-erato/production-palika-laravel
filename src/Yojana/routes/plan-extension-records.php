<?php
use \Src\Yojana\Controllers\PlanExtensionRecordAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/yojana/plan-extension-records', 'as'=>'admin.plan_extension_records.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[PlanExtensionRecordAdminController::class,'index'])->name('index');
    Route::get('/create',[PlanExtensionRecordAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[PlanExtensionRecordAdminController::class,'edit'])->name('edit');
});
