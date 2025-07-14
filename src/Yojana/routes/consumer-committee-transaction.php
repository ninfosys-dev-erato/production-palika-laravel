<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ConsumerCommitteeTransactionAdminController;

Route::group(['prefix' =>'admin/consumer_committee_transactions', 'as'=>'admin.consumer_committee_transactions.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[ConsumerCommitteeTransactionAdminController::class,'index'])->name('index');
    Route::get('/create',[ConsumerCommitteeTransactionAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ConsumerCommitteeTransactionAdminController::class,'edit'])->name('edit');
});
