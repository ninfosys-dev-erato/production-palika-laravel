<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ProjectAllocatedAmountAdminController;

Route::group(['prefix' =>'admin/project_allocated_amounts', 'as'=>'admin.project_allocated_amounts.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[ProjectAllocatedAmountAdminController::class,'index'])->name('index');
    Route::get('/create',[ProjectAllocatedAmountAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ProjectAllocatedAmountAdminController::class,'edit'])->name('edit');
});
