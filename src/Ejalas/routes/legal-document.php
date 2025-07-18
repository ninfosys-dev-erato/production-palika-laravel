<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\LegalDocumentAdminController;

Route::group(['prefix' => 'admin/ejalas/legal_documents', 'as' => 'admin.ejalas.legal_documents.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/', [LegalDocumentAdminController::class, 'index'])->name('index');
    Route::get('/create', [LegalDocumentAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [LegalDocumentAdminController::class, 'edit'])->name('edit');
    Route::get('/preview/{id}', [LegalDocumentAdminController::class, 'preview'])->name('preview');
});
