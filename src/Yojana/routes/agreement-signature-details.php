<?php
use \Src\Yojana\Controllers\AgreementSignatureDetailAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/agreement_signature_details', 'as'=>'admin.agreement_signature_details.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[AgreementSignatureDetailAdminController::class,'index'])->name('index');
    Route::get('/create',[AgreementSignatureDetailAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[AgreementSignatureDetailAdminController::class,'edit'])->name('edit');
});
