<?php
use \Src\Ebps\Controllers\LandUseAreaAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/ebps/land-use-areas', 'as'=>'admin.ebps.land_use_areas.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[LandUseAreaAdminController::class,'index'])->name('index');
    Route::get('/create',[LandUseAreaAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[LandUseAreaAdminController::class,'edit'])->name('edit');
});
