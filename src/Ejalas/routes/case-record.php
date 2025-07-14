<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\CaseRecordAdminController;

Route::group(['prefix' => 'admin/ejalas/case_records', 'as' => 'admin.ejalas.case_records.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/', [CaseRecordAdminController::class, 'index'])->name('index');
    Route::get('/create', [CaseRecordAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [CaseRecordAdminController::class, 'edit'])->name('edit');
    Route::get('/preview/{id}', [CaseRecordAdminController::class, 'preview'])->name('preview');
    // Route::get('/report', [CaseRecordAdminController::class, 'report'])->name('report');
});
Route::group(['prefix' => 'admin/ejalas/case_records', 'as' => 'admin.ejalas.report.case_records.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/report', [CaseRecordAdminController::class, 'report'])->name('report');
});
