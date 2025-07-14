<?php
use \Src\Districts\Controllers\DistrictAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/districts', 'as'=>'admin.districts.','middleware'=>['web','auth'] ], function () {
    Route::get('/',[DistrictAdminController::class,'index'])->name('index');
    Route::get('/create',[DistrictAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[DistrictAdminController::class,'edit'])->name('edit');
});
