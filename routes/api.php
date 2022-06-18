<?php

use App\Http\Controllers\API\V1\Admin\ResourceController;
use App\Http\Controllers\API\V1\Admin\PdfResourceController;
use App\Http\Controllers\API\V1\Admin\HtmlResourceController;
use App\Http\Controllers\API\V1\Admin\LinkResourceController;
use App\Http\Controllers\API\V1\Admin\ResourceTypeController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/admin')->name('api.v1.admin.')->group(function() {
    Route::get('/resource-types/search', [ResourceTypeController::class, 'search'])->name('resource-types.search');
    Route::apiResource('resource-types', ResourceTypeController::class);
    Route::apiResource('resources', ResourceController::class)->except(['store', 'update']);
    Route::post('/pdf-resources/{pdf_resource}', [PdfResourceController::class, 'update'])->name('pdf-resources.update');
    Route::apiResource('pdf-resources', PdfResourceController::class)->only(['store']);
    Route::apiResource('html-resources', HtmlResourceController::class)->only(['store', 'update']);
    Route::apiResource('link-resources', LinkResourceController::class)->only(['store', 'update']);
});
