<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\ProjectDocumentAdminController;

Route::group(['prefix' =>'admin/project_documents', 'as'=>'admin.project_documents.','middleware'=>['web','auth', 'check_module:plan'] ], function () {
    Route::get('/',[ProjectDocumentAdminController::class,'index'])->name('index');
    Route::get('/create',[ProjectDocumentAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[ProjectDocumentAdminController::class,'edit'])->name('edit');
});
