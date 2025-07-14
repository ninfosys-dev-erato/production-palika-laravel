<?php

use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ConsumerCommitteeMemberAdminController;

Route::group(['prefix' =>'admin/consumer_committee_members', 'as'=>'admin.consumer_committee_members.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[ConsumerCommitteeMemberAdminController::class,'index'])->name('index');
    Route::get('/create/{consumerCommitteeId?}',[ConsumerCommitteeMemberAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ConsumerCommitteeMemberAdminController::class,'edit'])->name('edit');
});
