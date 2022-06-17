<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Front\IndexController;
use App\Http\Controllers\Web\Admin\VueAdminLayoutController;

// Web
Route::name('web.')->group(function() {
    // Web Front
    Route::name('front.')->group(function() {
        Route::get('/', [IndexController::class, 'index'])->name('index.index');
    });

    // Web Admin
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::get('/', [VueAdminLayoutController::class, 'layout'])->name('vue-admin.layout');
    });
});
