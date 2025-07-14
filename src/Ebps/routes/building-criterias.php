<?php
use \Src\Ebps\Controllers\BuildingCriteriaAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/ebps/building_criterias', 'as'=>'admin.ebps.building_criterias.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[BuildingCriteriaAdminController::class,'index'])->name('index');
    Route::get('/create',[BuildingCriteriaAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[BuildingCriteriaAdminController::class,'edit'])->name('edit');
});
