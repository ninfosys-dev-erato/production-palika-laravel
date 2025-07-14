<?php

use Frontend\CustomerPortal\Ebps\Controllers\BuildingRegistrationController;
use Frontend\CustomerPortal\Ebps\Controllers\CustomerLandDetailController;
use Frontend\CustomerPortal\Ebps\Controllers\MapApplyController;
use Frontend\CustomerPortal\Ebps\Livewire\CustomerMapApplyStep;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['web','customer'], 'prefix' => 'customer/ebps', 'as' => 'customer.ebps.'], function () {
    Route::get('/',[CustomerLandDetailController::class,'index'])->name('land-detail-index');
    Route::get('/create',[CustomerLandDetailController::class,'create'])->name('land-detail-create');
    Route::get('/edit/{id}',[CustomerLandDetailController::class,'edit'])->name('land-detail-edit');


});

Route::group(['middleware' => ['web','customer'], 'prefix' => 'customer/ebps/apply', 'as' => 'customer.ebps.apply.'], function () {
Route::get('/',[MapApplyController::class,'index'])->name('map-apply.index');
Route::get('/create',[MapApplyController::class,'create'])->name('map-apply.create');
Route::get('/edit/{id}',[MapApplyController::class,'edit'])->name('map-apply.edit');
Route::get('/show/{id}',[MapApplyController::class,'show'])->name('map-apply.show');
Route::get('/steps/{id}',[MapApplyController::class,'moveForward'])->name('step');
Route::get('/apply-step/{mapStep}/{mapApply}', [MapApplyController::class, 'mapApplyStep'])->name('apply-map-step');
Route::get('/step/preview/{mapApplyStep}', [MapApplyController::class, 'previewMapStep'])->name('preview-map-step');

});



Route::group(['prefix' =>'customer/ebps/building-registrations', 'as'=>'customer.ebps.building-registrations.','middleware'=>['web', 'customer'] ], function () {
    Route::get('/',[BuildingRegistrationController::class,'index'])->name('index');
    Route::get('/create',[BuildingRegistrationController::class,'create'])->name('create');
    Route::get('/edit/{id}',[BuildingRegistrationController::class,'edit'])->name('edit');
    Route::get('/show/{id}',[BuildingRegistrationController::class,'show'])->name('view');
    Route::get('/steps/{id}',[BuildingRegistrationController::class,'moveForward'])->name('step');
    Route::get('/apply-step/{mapStep}/{mapApply}',[BuildingRegistrationController::class,'mapApplyStep'])->name('apply-step');
    Route::get('/step/preview/{mapApplyStep}', [BuildingRegistrationController::class, 'previewMapStep'])->name('preview');
});