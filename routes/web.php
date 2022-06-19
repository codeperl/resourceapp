<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Front\ResourceController;
use App\Http\Controllers\Web\Admin\VueAdminLayoutController;

// Web
Route::name('web.')->group(function() {
    // Web Front
    Route::name('front.')->group(function() {
        Route::get('/', [ResourceController::class, 'index'])->name('resources.index');
        Route::get('/resources/show/{resource}', [ResourceController::class, 'show'])->name('resources.show');
        Route::get('/resources/download/{fileName}', [ResourceController::class, 'download'])
            ->where('fileName', '^(.*\.pdf)$')
            ->name('resources.download');
    });

    // Web Admin
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::get('/', [VueAdminLayoutController::class, 'layout'])->name('vue-admin.layout');
    });
});
