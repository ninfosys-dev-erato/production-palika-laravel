<?php

use Illuminate\Support\Facades\Route;
use Src\Grievance\Controllers\GrievanceDashboardController;
use Src\Grievance\Controllers\GrievanceDetailController;
use Src\Grievance\Controllers\GrievanceSettingController;
use Src\Grievance\Controllers\GrievanceTypeController;

Route::group(['middleware' => ['auth', 'web', 'check_module:grievance'], 'prefix' => 'admin/grievances', 'as' => 'admin.grievance.'], function () {
    Route::get('/setting', [GrievanceSettingController::class, 'setting'])->name('setting')->middleware('permission:grievance_setting_access');
    Route::get('/', [GrievanceDashboardController::class, 'index'])->name('index');

    Route::get('/grievance-type', [GrievanceTypeController::class, 'index'])->name('grievanceType.index')->middleware('permission:grievance_type_access');
    Route::get('/grievance-type/create', [GrievanceTypeController::class, 'create'])->name('grievanceType.create')->middleware('permission:grievance_type_create');
    Route::get('/grievance-type/edit/{id}', [GrievanceTypeController::class, 'edit'])->name('grievanceType.edit')->middleware('permission:grievance_type_edit');
    Route::get('/grievance-type/manage/{id}', [GrievanceTypeController::class, 'manage'])->name('grievanceType.manage')->middleware('permission:grievance_type_access');
    Route::get('/grievance-detail', [GrievanceDetailController::class, 'index'])
        ->name('grievanceDetail.index')->middleware('permission:grievance_detail_access');
    Route::get('/create', [GrievanceDetailController::class, 'create'])
        ->name('create');
    Route::get('/grievance-detail/{grievanceDetail}', [GrievanceDetailController::class, 'show'])
        ->name('grievanceDetail.show');
    Route::get('/report',[GrievanceDashboardController::class, 'report'])
        ->name('grievanceDetail.report');
    Route::get('/applied-grievance-report',[GrievanceDashboardController::class, 'appliedGrievaceReport'])
        ->name('grievanceDetail.appliedGrievaceReport');
    Route::get('/notification',[GrievanceDashboardController::class, 'notification'])
        ->name('grievanceDetail.notification');
    Route::get('/export',[GrievanceDashboardController::class, 'export'])
        ->name('grievanceDetail.export');
    Route::get('/register/{id}', [GrievanceDetailController::class, 'register'])
        ->name('grievanceDetail.register');
    Route::get('/download-pdf',[GrievanceDashboardController::class, 'downloadPdf'])->name('download-pdf');
   
});
