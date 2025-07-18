<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\MaterialCollectionAdminController;

Route::group(['prefix' =>'admin/material_collections', 'as'=>'admin.material_collections.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[MaterialCollectionAdminController::class,'index'])->name('index');
    Route::get('/create',[MaterialCollectionAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[MaterialCollectionAdminController::class,'edit'])->name('edit');
});
