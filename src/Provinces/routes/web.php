<?php
use \Src\Provinces\Controllers\ProvinceAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/provinces', 'as'=>'admin.provinces.','middleware'=>['web','auth'] ], function () {
    Route::get('/',[ProvinceAdminController::class,'index'])->name('index');
    Route::get('/create',[ProvinceAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ProvinceAdminController::class,'edit'])->name('edit');
});
