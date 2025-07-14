<?php

use \Src\TaskTracking\Controllers\AnusuchiAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/task-reports/anusuchis', 'as' => 'admin.anusuchis.', 'middleware' => ['web', 'auth','check_module:task_tracking']], function () {
    Route::get('/', [AnusuchiAdminController::class, 'index'])->name('index');
    Route::get('/create', [AnusuchiAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [AnusuchiAdminController::class, 'edit'])->name('edit');
    Route::get('/template', [AnusuchiAdminController::class, 'template'])->name('template');
    Route::get('/report', [AnusuchiAdminController::class, 'report'])->name('report');
    Route::get('/add/report', [AnusuchiAdminController::class, 'addReport'])->name('addReport');
    Route::get('/add/report/{id}', [AnusuchiAdminController::class, 'editReport'])->name('editReport');
    Route::get('/report/view/{id}', [AnusuchiAdminController::class, 'viewReport'])->name('viewReport');
    Route::get('/report/print/{id}', [AnusuchiAdminController::class, 'printReport'])->name('printReport');
});
