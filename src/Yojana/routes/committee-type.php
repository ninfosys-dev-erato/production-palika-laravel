<?php
use Src\Yojana\Controllers\CommitteeTypeAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/plan_management_system/committee_types', 'as'=>'admin.committee_types.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[CommitteeTypeAdminController::class,'index'])->name('index');
    Route::get('/create',[CommitteeTypeAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[CommitteeTypeAdminController::class,'edit'])->name('edit');
});
