<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\LetterTypeAdminController;

Route::group(['prefix' => 'admin/plan_management_system/letter-types', 'as' => 'admin.letter_types.', 'middleware' => ['web', 'auth', 'check_module:plan']], function () {
    Route::get('/', [LetterTypeAdminController::class, 'index'])->name('index');
    Route::get('/create', [LetterTypeAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [LetterTypeAdminController::class, 'edit'])->name('edit');
});
