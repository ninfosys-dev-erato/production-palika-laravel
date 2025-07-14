<?php

use Illuminate\Support\Facades\Route;
use Src\DigitalBoard\Controllers\CitizenCharterAdminController;
use Src\DigitalBoard\Controllers\DigitalBoardDashboardController;
use Src\DigitalBoard\Controllers\NoticeAdminController;
use Src\DigitalBoard\Controllers\PopUpAdminController;
use Src\DigitalBoard\Controllers\ProgramAdminController;
use Src\DigitalBoard\Controllers\VideoAdminController;

Route::group(['prefix' => 'admin/digital-board', 'as' => 'admin.digital_board.', 'middleware' => ['web', 'auth', 'check_module:digital_board']], function () {
    Route::get('/', [DigitalBoardDashboardController::class, 'index'])->name('index');

    Route::group(['prefix' => 'videos', 'as' => 'videos.'], function () {
        Route::get('/', [VideoAdminController::class, 'index'])->name('index');
        Route::get('/create', [VideoAdminController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [VideoAdminController::class, 'edit'])->name('edit');
    });

    Route::group(['prefix' => 'pop-ups', 'as' => 'pop_ups.'], function () {
        Route::get('/', [PopUpAdminController::class, 'index'])->name('index');
        Route::get('/create', [PopUpAdminController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [PopUpAdminController::class, 'edit'])->name('edit');
    });

    Route::group(['prefix' => 'citizen-charters', 'as' => 'citizen_charters.'], function () {
        Route::get('/', [CitizenCharterAdminController::class, 'index'])->name('index');
        Route::get('/create', [CitizenCharterAdminController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [CitizenCharterAdminController::class, 'edit'])->name('edit');
    });

    Route::group(['prefix' => 'notices', 'as' => 'notices.'], function () {
        Route::get('/', [NoticeAdminController::class, 'index'])->name('index');
        Route::get('/create', [NoticeAdminController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [NoticeAdminController::class, 'edit'])->name('edit');
    });

    Route::group(['prefix' => 'programs', 'as' => 'programs.'], function () {
        Route::get('/', [ProgramAdminController::class, 'index'])->name('index');
        Route::get('/create', [ProgramAdminController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [ProgramAdminController::class, 'edit'])->name('edit');
    });
});
