<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\DisputeAreaAdminController;

Route::group(['prefix' =>'admin/dispute_areas', 'as'=>'admin.ejalas.dispute_areas.','middleware'=>['web','auth','check_module:ejalash'] ], function () {
    Route::get('/',[DisputeAreaAdminController::class,'index'])->name('index');
    Route::get('/create',[DisputeAreaAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[DisputeAreaAdminController::class,'edit'])->name('edit');
});
