<?php
use \Src\Ebps\Controllers\BuildingCriteriaAdminController;
use Illuminate\Support\Facades\Route;
use Src\Ebps\Controllers\BuildingRegistrationAdminController;

Route::group(['prefix' => 'admin/ebps/building-registrations', 'as' => 'admin.ebps.building-registrations.', 'middleware' => ['web', 'auth', 'check_module:ebps']], function () {
    Route::get('/', [BuildingRegistrationAdminController::class, 'index'])->name('index');
    Route::get('/create', [BuildingRegistrationAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [BuildingRegistrationAdminController::class, 'edit'])->name('edit');
    Route::get('/show/{id}', [BuildingRegistrationAdminController::class, 'show'])->name('view');
    Route::get('/steps/{id}', [BuildingRegistrationAdminController::class, 'moveForward'])->name('step');
    Route::get('/apply-step/{mapStep}/{mapApply}', [BuildingRegistrationAdminController::class, 'mapApplyStep'])->name('apply-step');
    Route::get('/step/preview/{mapApplyStep}', [BuildingRegistrationAdminController::class, 'previewMapStep'])->name('preview');
    Route::get('/print-form/{id}', [BuildingRegistrationAdminController::class, 'print'])->name('form.print');
});
