<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\CommitteeAdminController;
use Src\Yojana\Controllers\CommitteeMemberAdminController;
use Src\Yojana\Controllers\CommitteeTypeAdminController;

Route::group(['prefix' =>'admin/committees', 'as'=>'admin.committees.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/', [CommitteeAdminController::class, 'index'])->name('index')->middleware('permission:committee_access');
    Route::get('/create', [CommitteeAdminController::class, 'create'])->name('create')->middleware('permission:committee_create');
    Route::get('/edit/{id}', [CommitteeAdminController::class, 'edit'])->name('edit')->middleware('permission:committee_update');
});

Route::group(['prefix' => 'admin/plan_management_system/committee-members', 'as' => 'admin.committee-members.', 'middleware' => ['web', 'auth', 'check_module:plan']], function () {
    Route::get('/', [CommitteeMemberAdminController::class, 'index'])->name('index')->middleware('permission:committee_member_access');
    Route::get('/create', [CommitteeMemberAdminController::class, 'create'])->name('create')->middleware('permission:committee_member_create');
    Route::get('/edit/{id}', [CommitteeMemberAdminController::class, 'edit'])->name('edit')->middleware('permission:committee_member_update');
});

Route::group(['prefix' => 'admin/plan_management_system/committee-types', 'as' => 'admin.committee-types.', 'middleware' => ['web', 'auth', 'check_module:plan']], function () {
    Route::get('/', [CommitteeTypeAdminController::class, 'index'])->name('index')->middleware('permission:committee_type_access');
    Route::get('/create', [CommitteeTypeAdminController::class, 'create'])->name('create')->middleware('permission:committee_type_create');
    Route::get('/edit/{id}', [CommitteeTypeAdminController::class, 'edit'])->name('edit')->middleware('permission:committee_type_update');
});
