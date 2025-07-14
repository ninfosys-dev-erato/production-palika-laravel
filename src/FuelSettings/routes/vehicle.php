<?php

use Illuminate\Support\Facades\Route;
use Src\FuelSettings\Controllers\VehicleAdminController;

Route::group(['prefix' =>'admin/vehicles', 'as'=>'admin.vehicles.','middleware'=>['web','auth','check_module:fuel'] ], function () {
    Route::get('/',[VehicleAdminController::class,'index'])->name('index');
    Route::get('/create',[VehicleAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[VehicleAdminController::class,'edit'])->name('edit');
});
