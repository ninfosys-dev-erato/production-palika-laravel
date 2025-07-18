<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ProjectDeadlineExtensionAdminController;

Route::group(['prefix' =>'admin/project_deadline_extensions', 'as'=>'admin.project_deadline_extensions.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[ProjectDeadlineExtensionAdminController::class,'index'])->name('index');
    Route::get('/create',[ProjectDeadlineExtensionAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ProjectDeadlineExtensionAdminController::class,'edit'])->name('edit');
});
