<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\EjalasFormAdminController;
use Src\Ejalas\Controllers\LevelAdminController;
use Src\Settings\Controllers\FormController;

Route::group(['prefix' => 'admin/ejalas/forms', 'as' => 'admin.ejalas.', 'middleware' => ['web', 'auth', 'check_module:ejalash']], function () {
    Route::get('/', [EjalasFormAdminController::class, 'index'])->name('form-template.index');


    Route::get('/form/template/{id}', [FormController::class, 'template'])->name('form.template');
    Route::get('/form/create', [FormController::class, 'create'])->name('form.create');
    Route::get('/form/edit/{id}', [FormController::class, 'edit'])->name('form.edit');
});
