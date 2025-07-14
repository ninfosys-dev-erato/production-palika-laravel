<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\PartyAdminController;

Route::group(['prefix' =>'admin/parties', 'as'=>'admin.ejalas.parties.','middleware'=>['web','auth','check_module:ejalash'] ], function () {
    Route::get('/',[PartyAdminController::class,'index'])->name('index');
    Route::get('/create',[PartyAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[PartyAdminController::class,'edit'])->name('edit');
});
