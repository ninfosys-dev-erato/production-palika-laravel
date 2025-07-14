<?php
use \Src\Ebps\Controllers\StoreyAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/ebps/storeys', 'as'=>'admin.ebps.storeys.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[StoreyAdminController::class,'index'])->name('index');
    Route::get('/create',[StoreyAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[StoreyAdminController::class,'edit'])->name('edit');
});
