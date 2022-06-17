<?php

use App\Http\Controllers\API\V1\Admin\ResourceTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/admin')->name('api.v1.admin.')->group(function() {
    Route::apiResource('resource-types', ResourceTypeController::class);
});
