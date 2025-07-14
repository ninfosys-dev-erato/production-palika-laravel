<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\BankDetailAdminController;

Route::group(['prefix' =>'admin/bank_details', 'as'=>'admin.bank_details.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[BankDetailAdminController::class,'index'])->name('index');
    Route::get('/create',[BankDetailAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[BankDetailAdminController::class,'edit'])->name('edit');
});
