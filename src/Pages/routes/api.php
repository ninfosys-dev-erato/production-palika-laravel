<?php

use Src\Pages\Controllers\PageController;

Route::group(array('module'=>'Page','middleware' => ['web'],'namespace' => 'App\Src\Pages\Controllers'), function() {
    //Your routes belong to this module.
    Route::get('pages/{slug?}',[PageController::class,'index'])->name('pages');
    Route::get('api/pages/{slug?}',[PageController::class,'index']);

});