<?php

use Illuminate\Support\Facades\Route;
use Src\Settings\Controllers\AppSettingController;
use Src\Settings\Controllers\FormController;
use Src\Settings\Controllers\LetterHeadController;
use Src\Settings\Controllers\SettingController;

//Route::middleware(['auth:web'])
//    ->prefix('admin')
//    ->as('admin.')
//    ->group(function () {
//        Route::resource('setting', SettingController::class);
//    });

Route::group(['middleware' => ['auth', 'web'], 'prefix' => 'admin/settings', 'as' => 'admin.setting.'], function () {
    Route::get('/', [SettingController::class, 'index'])->name('index')->middleware('permission:office_setting_access');
    Route::get('/edit', [SettingController::class, 'editSetting'])->name('editsetting')->middleware('permission:office_setting_access');


    Route::get('/letter-head', [LetterHeadController::class, 'index'])->name('letter-head.index')->middleware('permission:letter_head_access');
    Route::get('/letter-head/create', [LetterHeadController::class, 'create'])->name('letter-head.create')->middleware('permission:letter_head_create');
    Route::get('/letter-head/edit/{id}', [LetterHeadController::class, 'edit'])->name('letter-head.edit')->middleware('permission:letter_head_update');

    Route::get('/form', [FormController::class, 'index'])->name('form.index')->middleware('permission:form_access');
    Route::get('/back', [FormController::class, 'goBack'])->name('back')->middleware('permission:form_access');
    Route::get('/form/create', [FormController::class, 'create'])->name('form.create')->middleware('permission:form_create');
    Route::get('/form/edit/{id}', [FormController::class, 'edit'])->name('form.edit')->middleware('permission:form_update');
    Route::get('/form/template/{id}', [FormController::class, 'template'])->name('form.template')->middleware('permission:form_update');

    Route::get('/app-setting', [AppSettingController::class, 'index'])->name('app-setting.index')->middleware('permission:app_setting_access');
});
