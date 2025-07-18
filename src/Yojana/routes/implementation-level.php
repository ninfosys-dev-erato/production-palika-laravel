<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ImplementationLevelAdminController;

Route::group(['prefix' =>'admin/implementation_levels', 'as'=>'admin.implementation_levels.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/', [ImplementationLevelAdminController::class, 'index'])->name('index');
    Route::get('/create', [ImplementationLevelAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [ImplementationLevelAdminController::class, 'edit'])->name('edit');
});
