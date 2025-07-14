<?php
use \Src\TokenTracking\Controllers\RegisterTokenLogAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/token-tracking/register-token-logs', 'as'=>'admin.register_token_logs.','middleware'=>['web','auth','check_module:token'] ], function () {
    Route::get('/',[RegisterTokenLogAdminController::class,'index'])->name('index');
    Route::get('/create',[RegisterTokenLogAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[RegisterTokenLogAdminController::class,'edit'])->name('edit');
});
