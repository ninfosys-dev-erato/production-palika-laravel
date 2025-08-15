<?php

use Illuminate\Support\Facades\Route;
use Src\Beruju\Controllers\DocumentTypeAdminController;

Route::group(['prefix' => 'admin/beruju/document-types', 'as' => 'admin.beruju.document-types.', 'middleware' => ['web', 'auth', 'check_module:beruju']], function () {
    Route::get('/', [DocumentTypeAdminController::class, 'index'])->name('index');
    Route::get('/create', [DocumentTypeAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [DocumentTypeAdminController::class, 'edit'])->name('edit');
    Route::get('/show/{id}', [DocumentTypeAdminController::class, 'show'])->name('show');
});
