<?php
use Illuminate\Support\Facades\Route;
use Src\Settings\Controllers\FormController;
use Src\Yojana\Controllers\LetterSampleAdminController;
use Src\Yojana\Controllers\YojanaFormTemplateController;

Route::group(['prefix' =>'admin/plan_management_system/letter_samples', 'as'=>'admin.letter_samples.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[LetterSampleAdminController::class,'index'])->name('index');
    Route::get('/create',[LetterSampleAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[LetterSampleAdminController::class,'edit'])->name('edit');
});

Route::group(['prefix' =>'admin/plan_management_system', 'as'=>'admin.plan_management_system.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/form/', [YojanaFormTemplateController::class, 'index'])->name('form-template.index')->middleware('permission:yojana_access');
    Route::get('/form-template/create', [YojanaFormTemplateController::class, 'create'])->name('form-template.create')->middleware('permission:yojana_access');
    Route::get('/form/create', [FormController::class, 'create'])->name('form.create')->middleware('permission:yojana_access');
    Route::get('/form/edit/{id}', [FormController::class, 'edit'])->name('form.edit')->middleware('permission:yojana_access');
    Route::get('/form/template/{id}', [FormController::class, 'template'])->name('form.template')->middleware('permission:yojana_access');
});
