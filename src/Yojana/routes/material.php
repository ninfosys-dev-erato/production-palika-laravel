<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\MaterialAdminController;

Route::group(['prefix' =>'admin/materials', 'as'=>'admin.materials.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[MaterialAdminController::class,'index'])->name('index');
    Route::get('/create',[MaterialAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[MaterialAdminController::class,'edit'])->name('edit');
});
