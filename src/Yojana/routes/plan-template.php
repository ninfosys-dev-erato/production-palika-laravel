<?php
use Illuminate\Support\Facades\Route;
use Src\Yojana\Controllers\PlanTemplateAdminController;

Route::group(['prefix' =>'admin/plan_templates', 'as'=>'admin.plan_templates.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[PlanTemplateAdminController::class,'index'])->name('index');
    Route::get('/create',[PlanTemplateAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[PlanTemplateAdminController::class,'edit'])->name('edit');
});
