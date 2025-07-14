<?php
use \Src\Ebps\Controllers\CantileverDetailAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/cantilever_details', 'as'=>'admin.cantilever_details.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[CantileverDetailAdminController::class,'index'])->name('index');
    Route::get('/create',[CantileverDetailAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[CantileverDetailAdminController::class,'edit'])->name('edit');
});
