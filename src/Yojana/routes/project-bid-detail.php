<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ProjectBidDetailAdminController;

Route::group(['prefix' =>'admin/project_bid_details', 'as'=>'admin.project_bid_details.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[ProjectBidDetailAdminController::class,'index'])->name('index');
    Route::get('/create',[ProjectBidDetailAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ProjectBidDetailAdminController::class,'edit'])->name('edit');
});
