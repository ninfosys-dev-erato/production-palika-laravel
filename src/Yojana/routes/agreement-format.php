<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\AgreementFormatAdminController;

Route::group(['prefix' =>'admin/agreement_formats', 'as'=>'admin.agreement_formats.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/', [AgreementFormatAdminController::class, 'index'])->name('index');
    Route::get('/create', [AgreementFormatAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [AgreementFormatAdminController::class, 'edit'])->name('edit');
});
