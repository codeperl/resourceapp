<?php

namespace App\Providers;

use App\Http\Controllers\API\V1\Admin\HtmlResourceController;
use App\Http\Controllers\API\V1\Admin\LinkResourceController;
use App\Http\Controllers\API\V1\Admin\PdfResourceController;
use App\Http\Controllers\API\V1\Admin\ResourceController;
use App\Services\Contracts\FileUploaderContract;
use App\Services\Contracts\ResourceContract;
use App\Services\Contracts\ResourceTypeContract;
use App\Services\FileUploaderService;
use App\Services\HtmlResourceService;
use App\Services\LinkResourceService;
use App\Services\PdfResourceService;
use App\Services\ResourceService;
use App\Services\ResourceTypeService;
use Illuminate\Support\ServiceProvider;

class BusinessServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(ResourceTypeContract::class, ResourceTypeService::class);
        $this->app->singleton(FileUploaderContract::class, FileUploaderService::class);
        $this->app
            ->when(ResourceController::class)
            ->needs(ResourceContract::class)
            ->give(ResourceService::class);

        $this->app
            ->when(PdfResourceController::class)
            ->needs(ResourceContract::class)
            ->give(PdfResourceService::class);

        $this->app
            ->when(HtmlResourceController::class)
            ->needs(ResourceContract::class)
            ->give(HtmlResourceService::class);

        $this->app
            ->when(LinkResourceController::class)
            ->needs(ResourceContract::class)
            ->give(LinkResourceService::class);
    }
}
