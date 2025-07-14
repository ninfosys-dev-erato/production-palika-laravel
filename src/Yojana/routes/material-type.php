<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\MaterialTypeAdminController;

Route::group(['prefix' =>'admin/material_types', 'as'=>'admin.material_types.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[MaterialTypeAdminController::class,'index'])->name('index');
    Route::get('/create',[MaterialTypeAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[MaterialTypeAdminController::class,'edit'])->name('edit');
});
