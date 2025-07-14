<?php

use Illuminate\Support\Facades\Route;
use Src\Settings\Controllers\SettingGroupAdminController;

Route::group(['prefix' =>'admin/setting_groups', 'as'=>'admin.setting_groups.','middleware'=>['web','auth'] ], function () {
    Route::get('/',[SettingGroupAdminController::class,'index'])->name('index');
    Route::get('/create',[SettingGroupAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[SettingGroupAdminController::class,'edit'])->name('edit');
    Route::get('/manage/{id}',[SettingGroupAdminController::class,'manage'])->name('manage');
});
