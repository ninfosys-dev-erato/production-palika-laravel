<?php

use Illuminate\Support\Facades\Route;
use Src\TokenTracking\Controllers\TokenFeedbackAdminController;

Route::group(['prefix' =>'admin/token-feedbacks', 'as'=>'admin.token_feedbacks.','middleware'=>['web','auth','check_module:token'] ], function () {
    Route::get('/',[TokenFeedbackAdminController::class,'index'])->name('index');
    Route::get('/create',[TokenFeedbackAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[TokenFeedbackAdminController::class,'edit'])->name('edit');
});
