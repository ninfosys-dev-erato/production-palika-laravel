<?php
use Src\Meetings\Controllers\AgendaAdminController;
use Src\Meetings\Controllers\DecisionAdminController;
use Src\Meetings\Controllers\InvitedMemberAdminController;
use \Src\Meetings\Controllers\MeetingAdminController;
use Illuminate\Support\Facades\Route;
use Src\Meetings\Controllers\MeetingDashboardController;
use Src\Meetings\Controllers\ParticipantAdminController;

Route::group(['prefix' => 'admin/meetings', 'as' => 'admin.meetings.', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', [MeetingDashboardController::class, 'index'])->name('dashboard')->middleware('permission:meeting_access');
    Route::get('/index', [MeetingAdminController::class, 'index'])->name('index')->middleware('permission:meeting_access');
    Route::get('/create', [MeetingAdminController::class, 'create'])->name('create')->middleware('permission:meeting_create');
    Route::get('/edit/{id}', [MeetingAdminController::class, 'edit'])->name('edit')->middleware('permission:meeting_update');
    Route::get('/manage/{id}', [MeetingAdminController::class, 'manage'])->name('manage')->middleware('permission:meeting_access');

});

Route::group(['prefix' =>'admin/meeting/{meeting}/invited-members', 'as'=>'admin.invited-members.','middleware'=>['web','auth'] ], function () {
   Route::get('/edit/{id}',[InvitedMemberAdminController::class,'edit'])->name('edit')->middleware('permission:meeting_invited_member_update');
});

Route::group(['prefix' =>'admin/meeting/{meeting}/agendas', 'as'=>'admin.agendas.','middleware'=>['web','auth'] ], function () {
    Route::get('/edit/{id}',[AgendaAdminController::class,'edit'])->name('edit')->middleware('permission:meeting_agenda_update');
});

Route::group(['prefix' =>'admin/meeting/{meeting}/participants', 'as'=>'admin.participants.','middleware'=>['web','auth'] ], function () {
    Route::get('/edit/{id}',[ParticipantAdminController::class,'edit'])->name('edit')->middleware('permission:meeting_participants_update');
});

Route::group(['prefix' =>'admin/meeting/{meeting}/decisions', 'as'=>'admin.decisions.','middleware'=>['web','auth'] ], function () {
    Route::get('/edit/{id}',[DecisionAdminController::class,'edit'])->name('edit')->middleware('permission:meeting_decision_update');
});
