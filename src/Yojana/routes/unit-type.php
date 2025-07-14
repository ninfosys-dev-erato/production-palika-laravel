<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\UnitTypeAdminController;

Route::group(['prefix' =>'admin/plan_management_system/unit_types', 'as'=>'admin.unit_types.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[UnitTypeAdminController::class,'index'])->name('index');
    Route::get('/create',[UnitTypeAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[UnitTypeAdminController::class,'edit'])->name('edit');
});
