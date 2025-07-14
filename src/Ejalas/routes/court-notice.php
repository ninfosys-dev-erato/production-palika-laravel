<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\CourtNoticeAdminController;

Route::group(['prefix' => 'admin/ejalas/court_notices', 'as' => 'admin.ejalas.court_notices.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/', [CourtNoticeAdminController::class, 'index'])->name('index');
    Route::get('/create', [CourtNoticeAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [CourtNoticeAdminController::class, 'edit'])->name('edit');
    Route::get('/preview/{id}', [CourtNoticeAdminController::class, 'preview'])->name('preview');
});
