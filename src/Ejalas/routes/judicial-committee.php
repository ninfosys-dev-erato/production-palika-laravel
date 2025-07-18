<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\JudicialCommitteeAdminController;

Route::group(['prefix' =>'admin/judicial_committees', 'as'=>'admin.ejalas.judicial_committees.','middleware'=>['web','auth','check_module:ejalash'] ], function () {
    Route::get('/',[JudicialCommitteeAdminController::class,'index'])->name('index');
    Route::get('/create',[JudicialCommitteeAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[JudicialCommitteeAdminController::class,'edit'])->name('edit');
});
