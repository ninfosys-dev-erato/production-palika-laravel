<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\LocalLevelAdminController;

Route::group(['prefix' =>'admin/local_levels', 'as'=>'admin.ejalas.local_levels.','middleware'=>['web','auth','check_module:ejalash'] ], function () {
    Route::get('/',[LocalLevelAdminController::class,'index'])->name('index');
    Route::get('/create',[LocalLevelAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[LocalLevelAdminController::class,'edit'])->name('edit');
});
