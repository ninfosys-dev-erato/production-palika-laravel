<?php
use \Src\Yojana\Controllers\AgreementGrantAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/agreement_grants', 'as'=>'admin.agreement_grants.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[AgreementGrantAdminController::class,'index'])->name('index');
    Route::get('/create',[AgreementGrantAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[AgreementGrantAdminController::class,'edit'])->name('edit');
});
