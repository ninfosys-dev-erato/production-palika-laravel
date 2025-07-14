<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\PriotityAdminController;

Route::group(['prefix' =>'admin/priotities', 'as'=>'admin.ejalas.priotities.','middleware'=>['web','auth','check_module:ejalash'] ], function () {
    Route::get('/',[PriotityAdminController::class,'index'])->name('index');
    Route::get('/create',[PriotityAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[PriotityAdminController::class,'edit'])->name('edit');
});
