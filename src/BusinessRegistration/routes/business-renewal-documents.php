<?php

use Illuminate\Support\Facades\Route;
use Src\BusinessRegistration\Controllers\BusinessRenewalDocumentAdminController;

Route::group(['prefix' => 'admin/business-renewal-documents', 'as' => 'admin.business_renewal_documents.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', [BusinessRenewalDocumentAdminController::class, 'index'])->name('index');
    Route::get('/create', [BusinessRenewalDocumentAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [BusinessRenewalDocumentAdminController::class, 'edit'])->name('edit');
});
