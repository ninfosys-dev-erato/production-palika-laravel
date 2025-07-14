<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\JudicialEmployeeAdminController;

Route::group(['prefix' =>'admin/judicial_employees', 'as'=>'admin.ejalas.judicial_employees.','middleware'=>['web','auth','check_module:ejalash'] ], function () {
    Route::get('/', [JudicialEmployeeAdminController::class, 'index'])->name('index');
    Route::get('/create', [JudicialEmployeeAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [JudicialEmployeeAdminController::class, 'edit'])->name('edit');
});
