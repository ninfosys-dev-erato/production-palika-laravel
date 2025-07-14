<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ImplementationMethodAdminController;

Route::group(['prefix' =>'admin/implementation_methods', 'as'=>'admin.implementation_methods.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/', [ImplementationMethodAdminController::class, 'index'])->name('index');
    Route::get('/create', [ImplementationMethodAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [ImplementationMethodAdminController::class, 'edit'])->name('edit');
});
