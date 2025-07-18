<?php
use \Src\Ebps\Controllers\DistanceToWallAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/distance_to_walls', 'as'=>'admin.distance_to_walls.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[DistanceToWallAdminController::class,'index'])->name('index');
    Route::get('/create',[DistanceToWallAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[DistanceToWallAdminController::class,'edit'])->name('edit');
});
