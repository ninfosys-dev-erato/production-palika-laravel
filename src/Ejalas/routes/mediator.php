<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\MediatorAdminController;

Route::group(['prefix' =>'admin/mediators', 'as'=>'admin.ejalas.mediators.','middleware'=>['web','auth','check_module:ejalash'] ], function () {
    Route::get('/',[MediatorAdminController::class,'index'])->name('index');
    Route::get('/create',[MediatorAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[MediatorAdminController::class,'edit'])->name('edit');
});
