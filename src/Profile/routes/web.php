<?php
use \Src\Agendas\Controllers\AgendaAdminController;
use Illuminate\Support\Facades\Route;
use Src\Profile\Controllers\UserProfileController;

Route::group(['prefix' =>'admin/profile', 'as'=>'admin.profile.','middleware'=>['web','auth'] ], function () {
    Route::get('update-profile',[UserProfileController::class,'index'])->name('index');
    Route::get('change-password',[UserProfileController::class,'passwordIndex'])->name('password-index');
});
