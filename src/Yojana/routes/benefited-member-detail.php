<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\BenefitedMemberDetailAdminController;

Route::group(['prefix' =>'admin/benefited_member_details', 'as'=>'admin.benefited_member_details.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[BenefitedMemberDetailAdminController::class,'index'])->name('index');
    Route::get('/create',[BenefitedMemberDetailAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[BenefitedMemberDetailAdminController::class,'edit'])->name('edit');
});
