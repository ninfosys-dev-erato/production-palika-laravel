<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\DisputeMatterAdminController;

Route::group(['prefix' =>'admin/dispute_matters', 'as'=>'admin.ejalas.dispute_matters.','middleware'=>['web','auth','check_module:ejalash'] ], function () {
    Route::get('/',[DisputeMatterAdminController::class,'index'])->name('index');
    Route::get('/create',[DisputeMatterAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[DisputeMatterAdminController::class,'edit'])->name('edit');
});
