<?php

use Illuminate\Support\Facades\Route;
use Src\Automation\Controllers\AutomationController;


//degenerate business route line
Route::group(['prefix' => 'admin/automate', 'as' => 'admin.automate.', 'middleware' => ['web']], function () {
    Route::get('/ward-users', [AutomationController::class, 'wardUsers'])->name('ward-users');
});
