<?php
use \Src\Ebps\Controllers\RoadAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/roads', 'as'=>'admin.roads.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[RoadAdminController::class,'index'])->name('index');
    Route::get('/create',[RoadAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[RoadAdminController::class,'edit'])->name('edit');
});
