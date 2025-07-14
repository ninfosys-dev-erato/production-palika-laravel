<?php

use Illuminate\Support\Facades\Route;
use Src\Ejalas\Controllers\JudicialMeetingAdminController;

Route::group(['prefix' =>'admin/judicial_meetings', 'as'=>'admin.ejalas.judicial_meetings.','middleware'=>['web','auth','check_module:ejalash'] ], function () {
    Route::get('/', [JudicialMeetingAdminController::class, 'index'])->name('index');
    Route::get('/create', [JudicialMeetingAdminController::class, 'create'])->name('create');
    Route::get('/edit/{id}', [JudicialMeetingAdminController::class, 'edit'])->name('edit');
    Route::get('/preview/{id}', [JudicialMeetingAdminController::class, 'preview'])->name('preview');
});
