<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\CargoHandlingAdminController;

Route::group(['prefix' =>'admin/cargo_handlings', 'as'=>'admin.cargo_handlings.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[CargoHandlingAdminController::class,'index'])->name('index');
    Route::get('/create',[CargoHandlingAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[CargoHandlingAdminController::class,'edit'])->name('edit');
});
