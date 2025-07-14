<?php
use \Src\Ebps\Controllers\MapApplyDetailAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/map_apply_details', 'as'=>'admin.map_apply_details.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[MapApplyDetailAdminController::class,'index'])->name('index');
    Route::get('/create',[MapApplyDetailAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[MapApplyDetailAdminController::class,'edit'])->name('edit');
});
