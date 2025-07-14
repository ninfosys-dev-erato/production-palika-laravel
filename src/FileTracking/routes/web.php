<?php

use Src\FileTracking\Controllers\ChalaniAdminController;
use Src\FileTracking\Controllers\DartaAdminController;
use \Src\FileTracking\Controllers\FileRecordAdminController;
use Illuminate\Support\Facades\Route;
use Src\FileTracking\Controllers\FileRecordLogAdminController;
use Src\FileTracking\Controllers\FormTemplateController;
use Src\Settings\Controllers\FormController;
use Src\FileTracking\Controllers\FileRecordNotifieeAdminController;
use Src\FileTracking\Controllers\DashboardController;

Route::group(['prefix' => 'admin/file-records', 'as' => 'admin.file_records.', 'middleware' => ['web', 'auth', 'check_module:register']], function () {
    Route::get('/', [FileRecordAdminController::class, 'index'])->name('index');
    Route::get('/create', [FileRecordAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [FileRecordAdminController::class, 'edit'])->name('edit');
    Route::get('/show/{id}', [FileRecordAdminController::class, 'show'])->name('show');
});

Route::group(['prefix' => 'admin/patrachar', 'as' => 'admin.file_records.', 'middleware' => ['web', 'auth', 'check_module:patrachar']], function () {
    Route::get('/inbox', [FileRecordAdminController::class, 'manage'])->name('manage');
    Route::get('/inbox/{id}', [FileRecordAdminController::class, 'inbox'])->name('inbox');
    Route::get('/starred', [FileRecordAdminController::class, 'starred'])->name('starred');
    Route::get('/compose', [FileRecordAdminController::class, 'compose'])->name('compose');
    Route::get('/sent', [FileRecordAdminController::class, 'sent'])->name('sent');
    });


Route::group(['prefix' => 'admin/patrachar', 'as' => 'admin.patrachar.', 'middleware' => ['web', 'auth', 'check_module:patrachar']], function () {
    Route::get('/form/', [FormTemplateController::class, 'index'])->name('form-template.index');
    Route::get('/form-template/create', [FormTemplateController::class, 'create'])->name('form-template.create');
    Route::get('/form/create', [FormController::class, 'create'])->name('form.create');
    Route::get('/form/edit/{id}', [FormController::class, 'edit'])->name('form.edit');
    Route::get('/form/template/{id}', [FormController::class, 'template'])->name('form.template');
    });



Route::group(['prefix' => 'admin/darta-chalani/', 'as' => 'admin.register_files.', 'middleware' => ['web', 'auth', 'check_module:register']], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/darta/', [DartaAdminController::class, 'index'])->name('index')->middleware('permission:darta_access');
    Route::get('/darta/create', [DartaAdminController::class, 'create'])->name('create')->middleware('permission:darta_create');
    Route::get('/darta/edit/{id}', [DartaAdminController::class, 'edit'])->name('edit')->middleware('permission:darta_update');
    Route::get('/darta/show/{id}', [DartaAdminController::class, 'show'])->name('show');
    Route::get('/darta/report', [DartaAdminController::class, 'report'])->name('report')->middleware('permission:darta_access');
    Route::get('/darta/export', [DartaAdminController::class, 'export'])->name('export')->middleware('permission:darta_access');
    Route::get('/darta/download-pdf', [DartaAdminController::class, 'downloadPdf'])->name('download-pdf')->middleware('permission:darta_access');

});
Route::group(['prefix' => 'admin/darta-chalani/', 'as' => 'admin.chalani.', 'middleware' => ['web', 'auth', 'check_module:register']], function () {
    Route::get('/chalani/', [ChalaniAdminController::class, 'index'])->name('index')->middleware('permission:chalani_access');
    Route::get('/chalani/create', [ChalaniAdminController::class, 'create'])->name('create')->middleware('permission:chalani_create');
    Route::get('/chalani/edit/{id}', [ChalaniAdminController::class, 'edit'])->name('edit')->middleware('permission:chalani_update');
    Route::get('/chalani/report', [ChalaniAdminController::class, 'report'])->name('report')->middleware('permission:chalani_access');
    Route::get('/chalani/export', [ChalaniAdminController::class, 'export'])->name('export')->middleware('permission:chalani_access');
    Route::get('/chalani/download-pdf', [ChalaniAdminController::class, 'downloadPdf'])->name('download-pdf')->middleware('permission:chalani_access');
});

Route::group(['prefix' => 'admin/file-record-notifiees', 'as' => 'admin.file_record_notifiees.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', [FileRecordNotifieeAdminController::class, 'index'])->name('index');
    Route::get('/create', [FileRecordNotifieeAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [FileRecordNotifieeAdminController::class, 'edit'])->name('edit');
});

Route::group(['prefix' => 'admin/file-record-logs', 'as' => 'admin.file_record_logs.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', [FileRecordLogAdminController::class, 'index'])->name('index');
    Route::get('/create', [FileRecordLogAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [FileRecordLogAdminController::class, 'edit'])->name('edit');
});
