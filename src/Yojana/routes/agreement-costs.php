<?php
use \Src\Yojana\Controllers\AgreementCostAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/agreement_costs', 'as'=>'admin.agreement_costs.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[AgreementCostAdminController::class,'index'])->name('index');
    Route::get('/create',[AgreementCostAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[AgreementCostAdminController::class,'edit'])->name('edit');
});
