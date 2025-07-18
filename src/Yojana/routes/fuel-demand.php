<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\FuelDemandAdminController;

Route::group(['prefix' =>'admin/fuel_demands', 'as'=>'admin.fuel_demands.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[FuelDemandAdminController::class,'index'])->name('index');
    Route::get('/create',[FuelDemandAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[FuelDemandAdminController::class,'edit'])->name('edit');
});
