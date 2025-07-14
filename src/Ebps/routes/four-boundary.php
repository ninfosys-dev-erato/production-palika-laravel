<?php
use \Src\Ebps\Controllers\FourBoundaryAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/four-boundaries', 'as'=>'admin.four_boundaries.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[FourBoundaryAdminController::class,'index'])->name('index');
    Route::get('/create',[FourBoundaryAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[FourBoundaryAdminController::class,'edit'])->name('edit');
});
