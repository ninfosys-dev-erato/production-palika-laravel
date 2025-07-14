<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\DisputeDeadlineAdminController;

Route::group(['prefix' => 'admin/ejalas/dispute_deadlines', 'as' => 'admin.ejalas.dispute_deadlines.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/', [DisputeDeadlineAdminController::class, 'index'])->name('index');
    Route::get('/create', [DisputeDeadlineAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [DisputeDeadlineAdminController::class, 'edit'])->name('edit');
    Route::get('/preview/{id}', [DisputeDeadlineAdminController::class, 'preview'])->name('preview');
    // Route::get('/report', [DisputeDeadlineAdminController::class, 'report'])->name('report');
});
Route::group(['prefix' => 'admin/ejalas/dispute_deadlines', 'as' => 'admin.ejalas.report.dispute_deadlines.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/report', [DisputeDeadlineAdminController::class, 'report'])->name('report');
});
