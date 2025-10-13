<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\AnusuchiFormAdminController;

Route::group(['prefix' => 'admin/ejalas/anusuchi-form', 'as' => 'admin.ejalas.anusuchi-form.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/', [AnusuchiFormAdminController::class, 'index'])->name('index');
    Route::get('/preview/{id}', [AnusuchiFormAdminController::class, 'preview'])->name('preview');
});
