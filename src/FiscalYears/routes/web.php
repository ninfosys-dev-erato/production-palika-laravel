<?php
use \Src\FiscalYears\Controllers\FiscalYearAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/setting/fiscal-years', 'as'=>'admin.setting.fiscal-years.','middleware'=>['web','auth'] ], function () {
    Route::get('/',[FiscalYearAdminController::class,'index'])->name('index')->middleware('permission:fiscal_year access');
    Route::get('/create',[FiscalYearAdminController::class,'create'])->name('create')->middleware('permission:fiscal_year create');
    Route::get('/edit/{id}',[FiscalYearAdminController::class,'edit'])->name('edit')->middleware('permission:fiscal_year edit');
});
