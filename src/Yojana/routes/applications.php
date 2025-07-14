<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ApplicationAdminController;

Route::group(['prefix' =>'admin/applications', 'as'=>'admin.applications.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[ApplicationAdminController::class,'index'])->name('index');
    Route::get('/create',[ApplicationAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ApplicationAdminController::class,'edit'])->name('edit');
});
