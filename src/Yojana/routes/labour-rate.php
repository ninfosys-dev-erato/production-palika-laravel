<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\LabourRateAdminController;

Route::group(['prefix' =>'admin/labour_rates', 'as'=>'admin.labour_rates.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[LabourRateAdminController::class,'index'])->name('index');
    Route::get('/create',[LabourRateAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[LabourRateAdminController::class,'edit'])->name('edit');
});
