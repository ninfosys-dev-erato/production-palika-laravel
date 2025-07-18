<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\RegistrationIndicatorAdminController;

Route::group(['prefix' =>'admin/registration_indicators', 'as'=>'admin.ejalas.registration_indicators.','middleware'=>['web','auth','check_module:ejalash'] ], function () {
    Route::get('/',[RegistrationIndicatorAdminController::class,'index'])->name('index');
    Route::get('/create',[RegistrationIndicatorAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[RegistrationIndicatorAdminController::class,'edit'])->name('edit');
});
