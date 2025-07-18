<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ProjectAgreementTermAdminController;

Route::group(['prefix' =>'admin/project_agreement_terms', 'as'=>'admin.project_agreement_terms.','middleware'=>['web','auth', 'check_module:plan'] ], function () {
    Route::get('/',[ProjectAgreementTermAdminController::class,'index'])->name('index');
    Route::get('/create',[ProjectAgreementTermAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ProjectAgreementTermAdminController::class,'edit'])->name('edit');
});
