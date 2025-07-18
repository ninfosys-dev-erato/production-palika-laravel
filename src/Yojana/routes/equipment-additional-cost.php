<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\EquipmentAdditionalCostAdminController;

Route::group(['prefix' =>'admin/equipment_additional_costs', 'as'=>'admin.equipment_additional_costs.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[EquipmentAdditionalCostAdminController::class,'index'])->name('index');
    Route::get('/create',[EquipmentAdditionalCostAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[EquipmentAdditionalCostAdminController::class,'edit'])->name('edit');
});
