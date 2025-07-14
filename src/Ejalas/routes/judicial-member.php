<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\JudicialMemberAdminController;

Route::group(['prefix' =>'admin/judicial_members', 'as'=>'admin.ejalas.judicial_members.','middleware'=>['web','auth','check_module:ejalash'] ], function () {
    Route::get('/',[JudicialMemberAdminController::class,'index'])->name('index');
    Route::get('/create',[JudicialMemberAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[JudicialMemberAdminController::class,'edit'])->name('edit');
});
