<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\HearingScheduleAdminController;

Route::group(['prefix' => 'admin/ejalas/hearing_schedules', 'as' => 'admin.ejalas.hearing_schedules.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/{from?}', [HearingScheduleAdminController::class, 'index'])->name('index');
    Route::get('/create/{from?}', [HearingScheduleAdminController::class, 'create'])->name('create');
    Route::get('/edit/{from?}/{id}', [HearingScheduleAdminController::class, 'edit'])->name('edit');
    Route::get('/preview/{id}', [HearingScheduleAdminController::class, 'preview'])->name('preview');
    // Route::get('/report', [HearingScheduleAdminController::class, 'report'])->name('report');
    // Route::get('/reconciliation/index', [HearingScheduleAdminController::class, 'reconciliationIndex'])->name('reconciliationIndex');
});
Route::group(['prefix' => 'admin/hearing_schedules', 'as' => 'admin.ejalas.report.hearing_schedules.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/report', [HearingScheduleAdminController::class, 'report'])->name('report');
});
Route::group(['prefix' => 'admin/hearing_schedules', 'as' => 'admin.ejalas.reconciliation.hearing_schedules.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/reconciliation/index', [HearingScheduleAdminController::class, 'reconciliationIndex'])->name('reconciliationIndex');
});
