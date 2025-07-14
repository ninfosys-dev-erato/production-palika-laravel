<?php
use \Src\GrantManagement\Controllers\HelplessnessTypeAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/grant-management/helplessness-types', 'as'=>'admin.helplessness_types.','middleware'=>['web','auth','check_module:grant'] ], function () {
    Route::get('/',[HelplessnessTypeAdminController::class,'index'])->name('index');
    Route::get('/create',[HelplessnessTypeAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[HelplessnessTypeAdminController::class,'edit'])->name('edit');
});
