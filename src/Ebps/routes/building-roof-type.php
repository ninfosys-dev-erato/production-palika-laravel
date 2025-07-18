<?php
use \Src\Ebps\Controllers\BuildingRoofTypeAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/ebps/building-roof-types', 'as'=>'admin.ebps.building_roof_types.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[BuildingRoofTypeAdminController::class,'index'])->name('index');
    Route::get('/create',[BuildingRoofTypeAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[BuildingRoofTypeAdminController::class,'edit'])->name('edit');
});
