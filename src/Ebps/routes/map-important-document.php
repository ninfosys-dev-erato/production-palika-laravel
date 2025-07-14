<?php
use Illuminate\Support\Facades\Route;
use Src\Ebps\Controllers\MapImportantDocumentAdminController;

Route::group(['prefix' =>'admin/ebps/map-important-documents', 'as'=>'admin.ebps.map_important_documents.','middleware'=>['web','auth','check_module:ebps'] ], function () {
    Route::get('/',[MapImportantDocumentAdminController::class,'index'])->name('index');
    Route::get('/create',[MapImportantDocumentAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[MapImportantDocumentAdminController::class,'edit'])->name('edit');
});
