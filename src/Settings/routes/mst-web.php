<?php
use \Src\Settings\Controllers\SettingAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/mst_settings', 'as'=>'admin.settings.','middleware'=>['web','auth'] ], function () {
    Route::get('/',[SettingAdminController::class,'index'])->name('index');
    Route::get('/create',[SettingAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[SettingAdminController::class,'edit'])->name('edit');
    Route::get('/manage/{slug?}',[SettingAdminController::class,'manage'])->name('manage');
});
