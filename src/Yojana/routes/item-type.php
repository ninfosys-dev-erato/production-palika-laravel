<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ItemTypeAdminController;

Route::group(['prefix' =>'admin/item_types', 'as'=>'admin.item_types.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[ItemTypeAdminController::class,'index'])->name('index');
    Route::get('/create',[ItemTypeAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ItemTypeAdminController::class,'edit'])->name('edit');
});
