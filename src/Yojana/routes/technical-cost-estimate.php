<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\TechnicalCostEstimateAdminController;

Route::group(['prefix' =>'admin/technical_cost_estimates', 'as'=>'admin.technical_cost_estimates.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[TechnicalCostEstimateAdminController::class,'index'])->name('index');
    Route::get('/create',[TechnicalCostEstimateAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[TechnicalCostEstimateAdminController::class,'edit'])->name('edit');
});
