<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\CourtSubmissionAdminController;

Route::group(['prefix' => 'admin/ejalas/court_submissions', 'as' => 'admin.ejalas.court_submissions.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/', [CourtSubmissionAdminController::class, 'index'])->name('index');
    Route::get('/create', [CourtSubmissionAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [CourtSubmissionAdminController::class, 'edit'])->name('edit');
    Route::get('/preview/{id}', [CourtSubmissionAdminController::class, 'preview'])->name('preview');
    // Route::get('/report', [CourtSubmissionAdminController::class, 'report'])->name('report');
});
Route::group(['prefix' => 'admin/ejalas/court_submissions', 'as' => 'admin.ejalas.report.court_submissions.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/report', [CourtSubmissionAdminController::class, 'report'])->name('report');
});
