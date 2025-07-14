<?php
use \Src\Yojana\Controllers\EvaluationCostDetailAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/evaluation_cost_details', 'as'=>'admin.evaluation_cost_details.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[EvaluationCostDetailAdminController::class,'index'])->name('index');
    Route::get('/create',[EvaluationCostDetailAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[EvaluationCostDetailAdminController::class,'edit'])->name('edit');
});
