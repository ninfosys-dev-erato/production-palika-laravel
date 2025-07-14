<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ItemAdminController;

Route::group(['prefix' =>'admin/plan_management_system/items', 'as'=>'admin.items.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[ItemAdminController::class,'index'])->name('index');
    Route::get('/create',[ItemAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ItemAdminController::class,'edit'])->name('edit');
});
