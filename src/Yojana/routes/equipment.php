<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\EquipmentAdminController;

Route::group(['prefix' =>'admin/equipment', 'as'=>'admin.equipment.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[EquipmentAdminController::class,'index'])->name('index');
    Route::get('/create',[EquipmentAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[EquipmentAdminController::class,'edit'])->name('edit');
});
