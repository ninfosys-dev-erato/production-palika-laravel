<?php
use \Src\EmergencyContacts\Controllers\EmergencyContactAdminController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>'admin/emergency-contacts', 'as'=>'admin.emergency-contacts.','middleware'=>['web','auth'] ], function () {
    Route::get('/',[EmergencyContactAdminController::class,'index'])->name('index')->middleware('permission:emergency_contact_access');
    Route::get('/create',[EmergencyContactAdminController::class,'create'])->name('create')->middleware('permission:emergency_contact_create');
    Route::get('/edit/{id}',[EmergencyContactAdminController::class,'edit'])->name('edit')->middleware('permission:emergency_contact_edit');
});
