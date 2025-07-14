<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\TargetEntryAdminController;

Route::group(['prefix' =>'admin/target-entries', 'as'=>'admin.target_entries.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[TargetEntryAdminController::class,'index'])->name('index');
    Route::get('/create',[TargetEntryAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[TargetEntryAdminController::class,'edit'])->name('edit');
});
