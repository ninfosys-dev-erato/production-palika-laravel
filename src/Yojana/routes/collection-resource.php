<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\CollectionResourceAdminController;

Route::group(['prefix' =>'admin/collection_resources', 'as'=>'admin.collection_resources.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[CollectionResourceAdminController::class,'index'])->name('index');
    Route::get('/create',[CollectionResourceAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[CollectionResourceAdminController::class,'edit'])->name('edit');
});
