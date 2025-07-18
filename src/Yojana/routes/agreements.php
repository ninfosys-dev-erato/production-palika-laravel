<?php
use \Src\Yojana\Controllers\AgreementAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/agreements', 'as'=>'admin.agreements.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[AgreementAdminController::class,'index'])->name('index');
    Route::get('/create',[AgreementAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[AgreementAdminController::class,'edit'])->name('edit');
});
