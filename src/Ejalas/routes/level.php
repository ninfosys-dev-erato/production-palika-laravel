<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\LevelAdminController;

Route::group(['prefix' =>'admin/levels', 'as'=>'admin.ejalas.levels.','middleware'=>['web','auth','check_module:ejalash'] ], function () {
    Route::get('/',[LevelAdminController::class,'index'])->name('index');
    Route::get('/create',[LevelAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[LevelAdminController::class,'edit'])->name('edit');
});
