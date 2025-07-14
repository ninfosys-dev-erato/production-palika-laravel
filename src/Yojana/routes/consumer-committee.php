<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ConsumerCommitteeAdminController;

Route::group(['prefix' =>'admin/consumer_committees', 'as'=>'admin.consumer_committees.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[ConsumerCommitteeAdminController::class,'index'])->name('index');
    Route::get('/create',[ConsumerCommitteeAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ConsumerCommitteeAdminController::class,'edit'])->name('edit');
    Route::get('/preview/{id}',[ConsumerCommitteeAdminController::class,'preview'])->name('preview');
});
