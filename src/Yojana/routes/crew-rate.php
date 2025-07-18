<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\CrewRateAdminController;

Route::group(['prefix' =>'admin/crew_rates', 'as'=>'admin.crew_rates.','middleware'=>['web','auth','check_module:plan']     ], function () {
    Route::get('/',[CrewRateAdminController::class,'index'])->name('index');
    Route::get('/create',[CrewRateAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[CrewRateAdminController::class,'edit'])->name('edit');
});
