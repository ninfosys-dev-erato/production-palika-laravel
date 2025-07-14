<?php

use Frontend\BusinessPortal\Ebps\Controllers\BuildingRegistrationController;
use Frontend\BusinessPortal\Ebps\Controllers\MapApplyController;

Route::group(['prefix' =>'organization/ebps/map-apply', 'as'=>'organization.ebps.map_apply.','middleware'=>['web'] ], function () {
    Route::get('/',[MapApplyController::class,'index'])->name('index');
    Route::get('/create/{customerId?}',[MapApplyController::class,'create'])->name('create');
    Route::get('/edit/{id}',[MapApplyController::class,'edit'])->name('edit');
    Route::get('/view/{id}',[MapApplyController::class,'show'])->name('show');
    Route::get('/steps/{id}',[MapApplyController::class,'moveForward'])->name('step');
    Route::get('/apply-step/{mapStep}/{mapApply}', [MapApplyController::class, 'mapApplyStep'])->name('apply-map-step');
    Route::get('/step/preview/{mapApplyStep}', [MapApplyController::class, 'previewMapStep'])->name('preview-map-step');
    Route::get('/additionalForm/{id}',[MapApplyController::class,'additionalForm'])->name('additionalForm');
});


Route::group(['prefix' =>'organization/ebps/building-registrations', 'as'=>'organization.ebps.building-registrations.','middleware'=>['web'] ], function () {
    Route::get('/',[BuildingRegistrationController::class,'index'])->name('index');
    Route::get('/create',[BuildingRegistrationController::class,'create'])->name('create');
    Route::get('/edit/{id}',[BuildingRegistrationController::class,'edit'])->name('edit');
    Route::get('/show/{id}',[BuildingRegistrationController::class,'show'])->name('view');
    Route::get('/steps/{id}',[BuildingRegistrationController::class,'moveForward'])->name('step');
    Route::get('/apply-step/{mapStep}/{mapApply}',[BuildingRegistrationController::class,'mapApplyStep'])->name('apply-step');
    Route::get('/step/preview/{mapApplyStep}', [BuildingRegistrationController::class, 'previewMapStep'])->name('preview');
});