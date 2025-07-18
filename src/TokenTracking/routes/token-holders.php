<?php

use Illuminate\Support\Facades\Route;
use Src\TokenTracking\Controllers\TokenHolderAdminController;

Route::group(['prefix' =>'admin/token-holders', 'as'=>'admin.token_holders.','middleware'=>['web','auth','check_module:token'] ], function () {
    Route::get('/',[TokenHolderAdminController::class,'index'])->name('index');
    Route::get('/create',[TokenHolderAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[TokenHolderAdminController::class,'edit'])->name('edit');
});
