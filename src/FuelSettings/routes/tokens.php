<?php

use Illuminate\Support\Facades\Route;
use Src\FuelSettings\Controllers\TokenAdminController;

Route::group(['prefix' =>'admin/tokens', 'as'=>'admin.tokens.','middleware'=>['web','auth','check_module:fuel'] ], function () {
    Route::get('/',[TokenAdminController::class,'index'])->name('index');
    Route::get('/create',[TokenAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[TokenAdminController::class,'edit'])->name('edit');
});
