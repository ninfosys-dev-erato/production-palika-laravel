<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ConsumerCommitteeOfficialAdminController;

Route::group(['prefix' =>'admin/consumer_committee_officials', 'as'=>'admin.consumer_committee_officials.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[ConsumerCommitteeOfficialAdminController::class,'index'])->name('index');
    Route::get('/create',[ConsumerCommitteeOfficialAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ConsumerCommitteeOfficialAdminController::class,'edit'])->name('edit');
});
