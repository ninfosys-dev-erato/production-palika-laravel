<?php

use \Src\Yojana\Controllers\EvaluationAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/yojana/evaluations', 'as' => 'admin.evaluations.', 'middleware' => ['web', 'auth', 'check_module:plan']], function () {
    Route::get('/', [EvaluationAdminController::class, 'index'])->name('index');
    Route::get('/create', [EvaluationAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}/{planId?}', [EvaluationAdminController::class, 'edit'])->name('edit');
});
