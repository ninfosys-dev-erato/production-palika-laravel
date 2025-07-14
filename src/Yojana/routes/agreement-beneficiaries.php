<?php
use \Src\Yojana\Controllers\AgreementBeneficiaryAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/agreement_beneficiaries', 'as'=>'admin.agreement_beneficiaries.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[AgreementBeneficiaryAdminController::class,'index'])->name('index');
    Route::get('/create',[AgreementBeneficiaryAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[AgreementBeneficiaryAdminController::class,'edit'])->name('edit');
});
