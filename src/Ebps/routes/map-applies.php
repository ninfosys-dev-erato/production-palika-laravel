<?php
use \Src\Ebps\Controllers\MapApplyAdminController;
use Illuminate\Support\Facades\Route;
use Src\Ebps\Controllers\OldMapApplyAdminController;

Route::group(['prefix' => 'admin/ebps/map-applies', 'as' => 'admin.ebps.map_applies.', 'middleware' => ['web', 'auth', 'check_module:ebps']], function () {
    Route::get('/', [MapApplyAdminController::class, 'index'])->name('index');
    Route::get('/create', [MapApplyAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [MapApplyAdminController::class, 'edit'])->name('edit');
    Route::get('/view/{id}', [MapApplyAdminController::class, 'view'])->name('view');
    Route::get('/steps/{id}', [MapApplyAdminController::class, 'moveForward'])->name('step');
    Route::get('/apply-step/{mapStep}/{mapApply}', [MapApplyAdminController::class, 'mapApplyStep'])->name('apply-map-step');
    Route::get('/step/preview/{mapApplyStep}', [MapApplyAdminController::class, 'previewMapStep'])->name('preview-map-step');
    Route::get('/print-form/{id}', [MapApplyAdminController::class, 'print'])->name('form.print');
    
});
Route::group(['prefix' => 'admin/ebps/', 'as' => 'admin.ebps.', 'middleware' => ['web', 'auth', 'check_module:ebps']], function () {
 
Route::get('/change-owner/{id}', [MapApplyAdminController::class, 'changeOwner'])->name('change-owner');
Route::get('/change-organization/{id}', [MapApplyAdminController::class, 'changeOrganization'])->name('change-organization');
Route::get('/owner-template/{houseOwnerId}', [MapApplyAdminController::class, 'showTemplate'])->name('show-template');
Route::get('/organization-template/{organizationId}/{mapApplyId}', [MapApplyAdminController::class, 'showOragnizationTemplate'])->name('show-organization-template');
});


Route::group(['prefix' => 'admin/ebps/old-applications', 'as' => 'admin.ebps.old_applications.', 'middleware' => ['web', 'auth', 'check_module:ebps']], function () {
    Route::get('/', [OldMapApplyAdminController::class, 'index'])->name('index');
    Route::get('/create', [OldMapApplyAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [OldMapApplyAdminController::class, 'edit'])->name('edit');
    Route::get('/view/{id}', [OldMapApplyAdminController::class, 'view'])->name('view');
    Route::get('/print-form/{id}', [OldMapApplyAdminController::class, 'print'])->name('form.print');

});
