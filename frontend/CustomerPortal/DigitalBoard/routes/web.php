<?php


use Frontend\CustomerPortal\DigitalBoard\Controllers\DigitalBoardController;



Route::group(['middleware' => ['web'], 'prefix' => 'digital-board', 'as' => 'digital-board.'], function () {
    Route::get('/', [DigitalBoardController::class, 'index'])->name('index');
    Route::get('/program/{id}', [DigitalBoardController::class, 'showProgramDetail'])->name('program.showDetail');
    Route::get('/programs', [DigitalBoardController::class, 'showPrograms'])->name('program.show');
    Route::get('/video/{id}', [DigitalBoardController::class, 'showVideoDetail'])->name('video.showDetail');
    Route::get('/videos', [DigitalBoardController::class, 'showVideos'])->name('video.show');
   
    Route::get('/notice/{id}', [DigitalBoardController::class, 'showNoticeDetail'])->name('notice.showDetail');
    Route::get('/notice', [DigitalBoardController::class, 'showNotices'])->name('notice.show');
    Route::get('/citizen-charter/{id?}', [DigitalBoardController::class, 'showCharterDetail'])->name('charter.showDetail');
    Route::get('/employee', [DigitalBoardController::class, 'showEmployees'])->name('employee.show');
    Route::get('/search-employees', [DigitalBoardController::class, 'searchEmployees'])->name('searchEmployees');
    Route::get('/ward/{id}', [DigitalBoardController::class, 'wardWiseDB'])->name('digital-board');
    Route::get('/branch/{branch}',[DigitalBoardController::class, 'branchWiseDB'])->name('digital-board');
});
