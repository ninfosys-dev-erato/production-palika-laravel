<?php

use \Src\Template\Controllers\TemplateController;

Route::group(['prefix' => 'template', 'as' => 'admin.tasks.', 'middleware' => ['web']], function () {
    Route::get('/dashboard', [TemplateController::class, 'dashboard']);
    Route::get('/pdfview', function () {
        return view('Template::pdfview');
    });
});
