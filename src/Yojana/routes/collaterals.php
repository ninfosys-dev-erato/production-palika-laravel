<?php
use \Src\Yojana\Controllers\CollateralAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/plan_management_system/collaterals', 'as'=>'admin.collaterals.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[CollateralAdminController::class,'index'])->name('index');
    Route::get('/create',[CollateralAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[CollateralAdminController::class,'edit'])->name('edit');
});
