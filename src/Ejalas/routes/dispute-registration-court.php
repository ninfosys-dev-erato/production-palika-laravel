<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\DisputeRegistrationCourtAdminController;

Route::group(['prefix' => 'admin/ejalas/dispute_registration_courts', 'as' => 'admin.ejalas.dispute_registration_courts.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/', [DisputeRegistrationCourtAdminController::class, 'index'])->name('index');
    Route::get('/create', [DisputeRegistrationCourtAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [DisputeRegistrationCourtAdminController::class, 'edit'])->name('edit');
    Route::get('/preview/{id}', [DisputeRegistrationCourtAdminController::class, 'preview'])->name('preview');
});
