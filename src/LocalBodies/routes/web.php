<?php
use \Src\LocalBodies\Controllers\LocalBodyAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/local-bodies', 'as'=>'admin.local-bodies.','middleware'=>['web','auth'] ], function () {
    Route::get('/',[LocalBodyAdminController::class,'index'])->name('index');
    Route::get('/create',[LocalBodyAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[LocalBodyAdminController::class,'edit'])->name('edit');
});
