<?php
use \Src\Yojana\Controllers\FuelRateAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/fuel_rates', 'as'=>'admin.fuel_rates.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[FuelRateAdminController::class,'index'])->name('index');
    Route::get('/create',[FuelRateAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[FuelRateAdminController::class,'edit'])->name('edit');
});
