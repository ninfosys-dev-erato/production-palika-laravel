<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DirectUploadController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Direct upload routes for cloud storage
Route::middleware(['auth:sanctum'])->prefix('upload')->group(function () {
    Route::post('signed-url', [DirectUploadController::class, 'getSignedUrl']);
    Route::post('confirm', [DirectUploadController::class, 'confirmUpload']);
    Route::delete('file', [DirectUploadController::class, 'deleteFile']);
    Route::post('temporary-url', [DirectUploadController::class, 'getTemporaryUrl']);
});

// Customer upload routes (for web session authenticated customers)
Route::middleware(['web', 'auth:customer'])->prefix('upload')->group(function () {
    Route::post('signed-url', [DirectUploadController::class, 'getSignedUrl']);
    Route::post('confirm', [DirectUploadController::class, 'confirmUpload']);
    Route::delete('file', [DirectUploadController::class, 'deleteFile']);
    Route::post('temporary-url', [DirectUploadController::class, 'getTemporaryUrl']);
});