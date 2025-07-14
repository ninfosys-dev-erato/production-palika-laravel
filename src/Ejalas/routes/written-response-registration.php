<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\WrittenResponseRegistrationAdminController;

Route::group(['prefix' => 'admin/ejalas/written_response_registrations', 'as' => 'admin.ejalas.written_response_registrations.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/', [WrittenResponseRegistrationAdminController::class, 'index'])->name('index');
    Route::get('/create', [WrittenResponseRegistrationAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [WrittenResponseRegistrationAdminController::class, 'edit'])->name('edit');
    Route::get('/preview/{id}', [WrittenResponseRegistrationAdminController::class, 'preview'])->name('preview');
});
