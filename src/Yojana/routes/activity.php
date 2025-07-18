<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ActivityAdminController;

Route::group(['prefix' =>'admin/activities', 'as'=>'admin.activities.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/', [ActivityAdminController::class, 'index'])->name('index');
    Route::get('/create', [ActivityAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [ActivityAdminController::class, 'edit'])->name('edit');
});
