<?php
use \Src\Ebps\Controllers\BuildingConstructionTypeAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/ebps/building-construction-types', 'as'=>'admin.ebps.building_construction_types.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[BuildingConstructionTypeAdminController::class,'index'])->name('index');
    Route::get('/create',[BuildingConstructionTypeAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[BuildingConstructionTypeAdminController::class,'edit'])->name('edit');
});
