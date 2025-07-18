<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\AdvancePaymentAdminController;

Route::group(['prefix' =>'admin/advance_payments', 'as'=>'admin.advance_payments.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[AdvancePaymentAdminController::class,'index'])->name('index');
    Route::get('/create',[AdvancePaymentAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[AdvancePaymentAdminController::class,'edit'])->name('edit');
});
