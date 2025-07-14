<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ProjectBidSubmissionAdminController;

Route::group(['prefix' =>'admin/project_bid_submissions', 'as'=>'admin.project_bid_submissions.','middleware'=>['web','auth', 'check_module:plan'] ], function () {
    Route::get('/',[ProjectBidSubmissionAdminController::class,'index'])->name('index');
    Route::get('/create',[ProjectBidSubmissionAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ProjectBidSubmissionAdminController::class,'edit'])->name('edit');
});
