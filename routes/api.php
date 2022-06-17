<?php

use App\Http\Controllers\API\V1\Admin\ResourceController;
use App\Http\Controllers\API\V1\Admin\ResourceTypeController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/admin')->name('api.v1.admin.')->group(function() {
    Route::get('/resource-types/search', [ResourceTypeController::class, 'search'])->name('resource-types.search');
    Route::apiResource('resource-types', ResourceTypeController::class);
    Route::apiResource('resources', ResourceController::class);
});
