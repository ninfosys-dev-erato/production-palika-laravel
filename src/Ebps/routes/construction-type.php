<?php
use \Src\Ebps\Controllers\ConstructionTypeAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/ebps/construction-types', 'as'=>'admin.ebps.construction_types.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[ConstructionTypeAdminController::class,'index'])->name('index');
    Route::get('/create',[ConstructionTypeAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ConstructionTypeAdminController::class,'edit'])->name('edit');
});
