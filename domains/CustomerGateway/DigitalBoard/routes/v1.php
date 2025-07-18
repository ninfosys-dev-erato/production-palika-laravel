<?php

use Domains\CustomerGateway\DigitalBoard\Api\CitizenCharterHandler;
use Domains\CustomerGateway\DigitalBoard\Api\NoticeHandler;
use Domains\CustomerGateway\DigitalBoard\Api\PopUpHandler;
use Domains\CustomerGateway\DigitalBoard\Api\ProgramHandler;
use Domains\CustomerGateway\DigitalBoard\Api\VideoHandler;
use Domains\CustomerGateway\Employee\Api\EmployeeHandler;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'api/v1/digital-board', 'as' => 'api.digital-board.'], function () {
    Route::get('/notices', [NoticeHandler::class, 'show'])->name('show');
    Route::get('/notice/{id}', [NoticeHandler::class, 'showDetail'])->name('showDetail');
    Route::get('/programs', [ProgramHandler::class, 'show'])->name('show');
    Route::get('/program/{id}', [ProgramHandler::class, 'showDetail'])->name('showDetail');
    Route::get('/videos', [VideoHandler::class, 'show'])->name('show');
    Route::get('/video/{id}', [VideoHandler::class, 'showDetail'])->name('showDetail');
    Route::get('/popups', [PopUpHandler::class, 'show'])->name('show');
    Route::get('/popup/{id}', [PopUpHandler::class, 'showDetail'])->name('showDetail');
    Route::get('/citizen-charters', [CitizenCharterHandler::class, 'show'])->name('show');
    Route::get('/citizen-charter/{id}', [CitizenCharterHandler::class, 'showDetail'])->name('showDetail');
    Route::get('/', [EmployeeHandler::class, 'show']);
});
