<?php
use \Src\Yojana\Controllers\OrganizationAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/plan_management_system/organizations', 'as'=>'admin.organizations.','middleware'=>['web','auth','check_module:plan'] ], function () {
    Route::get('/',[OrganizationAdminController::class,'index'])->name('index');
    Route::get('/create',[OrganizationAdminController::class,'create'])->name('create');
    Route::get('/edit/{id}',[OrganizationAdminController::class,'edit'])->name('edit');
});
