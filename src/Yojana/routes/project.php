<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ProjectAdminController;

Route::group(['prefix' =>'admin/projects', 'as'=>'admin.projects.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[ProjectAdminController::class,'index'])->name('index');
    Route::get('/create',[ProjectAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ProjectAdminController::class,'edit'])->name('edit');
});
