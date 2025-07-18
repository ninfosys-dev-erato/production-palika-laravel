<?php
use \Src\Ebps\Controllers\StoreyDetailAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/storey_details', 'as'=>'admin.storey_details.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[StoreyDetailAdminController::class,'index'])->name('index');
    Route::get('/create',[StoreyDetailAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[StoreyDetailAdminController::class,'edit'])->name('edit');
});
