<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\LogBookAdminController;

Route::group(['prefix' =>'admin/plan_management_system/log-books', 'as'=>'admin.log_books.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[LogBookAdminController::class,'index'])->name('index');
    Route::get('/create',[LogBookAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[LogBookAdminController::class,'edit'])->name('edit');
});
