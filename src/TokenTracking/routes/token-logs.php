<?php

use Illuminate\Support\Facades\Route;
use Src\TokenTracking\Controllers\TokenLogAdminController;

Route::group(['prefix' =>'admin/token-logs', 'as'=>'admin.token_logs.','middleware'=>['web','auth','check_module:token'] ], function () {
    Route::get('/',[TokenLogAdminController::class,'index'])->name('index');
    Route::get('/create',[TokenLogAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[TokenLogAdminController::class,'edit'])->name('edit');
});
