<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\FuelAdminController;

Route::group(['prefix' =>'admin/fuels', 'as'=>'admin.fuels.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[FuelAdminController::class,'index'])->name('index');
    Route::get('/create',[FuelAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[FuelAdminController::class,'edit'])->name('edit');
});
