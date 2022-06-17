<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Admin\VueAdminLayoutController;

Route::prefix('admin')->group(function() {
    Route::get('/', [VueAdminLayoutController::class, 'layout'])->name('admin.layout');
});
