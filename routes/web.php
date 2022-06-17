<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function() {
    Route::get('/', [VueAdminLayoutController::class, 'layout'])->name('admin.layout');
});
