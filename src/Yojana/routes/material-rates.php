<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\MaterialRateAdminController;

Route::group(['prefix' =>'admin/material_rates', 'as'=>'admin.material_rates.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[MaterialRateAdminController::class,'index'])->name('index');
    Route::get('/create',[MaterialRateAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[MaterialRateAdminController::class,'edit'])->name('edit');
});
