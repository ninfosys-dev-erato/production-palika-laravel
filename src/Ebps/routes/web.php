<?php
use Src\Ebps\Controllers\EbpsSystemDashboardController;
use Illuminate\Support\Facades\Route;
use Src\Ebps\Controllers\EbpsFormTemplateController;
use Src\Settings\Controllers\FormController;

Route::group(['prefix' =>'admin/ebps', 'as'=>'admin.ebps.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[EbpsSystemDashboardController::class,'index'])->name('index');
    Route::get('/form/', [EbpsFormTemplateController::class, 'index'])->name('form-template.index');
    Route::get('/form-template/create', [EbpsFormTemplateController::class, 'create'])->name('form-template.create');
    Route::get('/form/create', [FormController::class, 'create'])->name('form.create');
    Route::get('/form/edit/{id}', [FormController::class, 'edit'])->name('form.edit');
    Route::get('/form/template/{id}', [FormController::class, 'template'])->name('form.template');

    Route::get('/report', [EbpsSystemDashboardController::class, 'report'])->name('report');
    Route::get('/template/{formId}', [EbpsSystemDashboardController::class, 'template'])->name('template');
    Route::get('/print/{formId}', [EbpsSystemDashboardController::class, 'print'])->name('print');

    Route::get('/requested-change', [EbpsSystemDashboardController::class, 'requestedChange'])->name('requested-change');
});
