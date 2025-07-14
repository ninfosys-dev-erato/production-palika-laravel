<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\BenefitedMemberAdminController;

Route::group(['prefix' =>'admin/benefited_members', 'as'=>'admin.benefited_members.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/', [BenefitedMemberAdminController::class, 'index'])->name('index');
    Route::get('/create', [BenefitedMemberAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [BenefitedMemberAdminController::class, 'edit'])->name('edit');
});
