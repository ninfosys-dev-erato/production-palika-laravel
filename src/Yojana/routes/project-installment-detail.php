<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ProjectInstallmentDetailAdminController;

Route::group(['prefix' =>'admin/project_installment_details', 'as'=>'admin.project_installment_details.','middleware'=>['web','auth', 'check_module:plan'] ], function () {
    Route::get('/',[ProjectInstallmentDetailAdminController::class,'index'])->name('index');
    Route::get('/create',[ProjectInstallmentDetailAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ProjectInstallmentDetailAdminController::class,'edit'])->name('edit');
});
