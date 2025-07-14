<?php

use Illuminate\Support\Facades\Route;
use Frontend\TokenPortal\TokenTv\Controllers\TokenTvController;


Route::group(['middleware' => ['web'], 'prefix' => 'token-tv', 'as' => 'token-tv.'], function () {
    Route::get('/', [TokenTvController::class, 'index'])->name('index');
});
