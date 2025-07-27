<?php
use \Src\Downloads\Controllers\DownloadAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/downloads', 'as'=>'admin.downloads.','middleware'=>['web','auth'] ], function () {
    Route::get('/',[DownloadAdminController::class,'index'])->name('index')->middleware('permission:downloads access');
    Route::get('/create',[DownloadAdminController::class,'create'])->name('create')->middleware('permission:downloads create');
    Route::get('/edit/{id}',[DownloadAdminController::class,'edit'])->name('edit')->middleware('permission:downloads edit');
});
