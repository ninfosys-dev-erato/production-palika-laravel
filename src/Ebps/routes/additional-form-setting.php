<?php

use \Src\Ebps\Controllers\AdditionalFormSettingAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/ebps/additional-form-setting', 'as' => 'admin.ebps.additional_form_settings.', 'middleware' => ['web', 'auth', 'check_module:ebps']], function () {
    Route::get('/', [AdditionalFormSettingAdminController::class, 'index'])->name('index');
    Route::get('/create', [AdditionalFormSettingAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [AdditionalFormSettingAdminController::class, 'edit'])->name('edit');
});
