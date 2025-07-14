<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ImplementationAgencyAdminController;

Route::group(['prefix' =>'admin/implementation-agencies', 'as'=>'admin.implementation_agencies.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[ImplementationAgencyAdminController::class,'index'])->name('index');
    Route::get('/create',[ImplementationAgencyAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ImplementationAgencyAdminController::class,'edit'])->name('edit');
});
