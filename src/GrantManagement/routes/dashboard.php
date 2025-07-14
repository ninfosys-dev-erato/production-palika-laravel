<?php
use \Src\GrantManagement\Controllers\GrantManagementDashboard;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/grant-management', 'as'=>'admin.grant_management.','middleware'=>['web','auth','check_module:grant'] ], function () {
    Route::get('/',[GrantManagementDashboard::class,'index'])->name('index');
});
