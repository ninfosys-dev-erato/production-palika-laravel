<?php

use Src\AdminSettings\Controllers\AdminSettingController;
use Src\AdminSettings\Controllers\AdminSettingGroupController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/admin_settings', 'as' => 'admin.admin_setting.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/group', [AdminSettingGroupController::class, 'index'])->name('group.index')->middleware('permission:group_access');
    Route::get('/group/create', [AdminSettingGroupController::class, 'create'])->name('group.create')->middleware('permission:group_create');
    Route::get('/group/edit/{id}', [AdminSettingGroupController::class, 'edit'])->name('group.edit')->middleware('permission:group_update');

    Route::get('/setting', [AdminSettingController::class, 'index'])->name('setting.index')->middleware('permission:setting_access');
    Route::get('/setting/create', [AdminSettingController::class, 'create'])->name('setting.create')->middleware('permission:setting_create');
    Route::get('/setting/edit/{id}', [AdminSettingController::class, 'edit'])->name('setting.edit')->middleware('permission:setting_update');
});
