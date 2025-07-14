<?php
use \Src\Ebps\Controllers\MapStepAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/ebps/map-steps', 'as'=>'admin.ebps.map_steps.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[MapStepAdminController::class,'index'])->name('index');
    Route::get('/create',[MapStepAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[MapStepAdminController::class,'edit'])->name('edit');
});
